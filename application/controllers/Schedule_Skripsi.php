<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Schedule_Skripsi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Skpschedule_model');
	}

	public function index()
	{
		if (!$this->session->userdata('is_login')) {
			redirect('login');
		} else {
			if ($this->session->userdata('group_id') == 1) {
				$this->mahasiswa();
			} else if ($this->session->userdata('group_id') == 2) {
				$this->dosen();
			} else if ($this->session->userdata('group_id') == 3) {
				$this->koordinator();
			} else if ($this->session->userdata('group_id') == 4) {
				$this->admin();
			} else {
				redirect('login');
			}
		}
	}

	public function mahasiswa()
	{
		if ($this->session->userdata('group_id') != 1) {
			redirect('error404');
		}

		$mhs = $this->Skpschedule_model->getMhs($this->session->userdata('user_id'));
		$all = $this->Skpschedule_model->getAll();
		$data = [
			'title' => "Jadwal Ujian Skripsi",
			'content' => 'schedule/skripsi/mahasiswa/mahasiswa',
			'mhs' => $mhs,
			'all' => $all,
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}


	public function dosen()
	{
		if ($this->session->userdata('group_id') != 2) {
			redirect('error404');
		}

		$dsn = $this->Skpschedule_model->getDsn($this->session->userdata('user_id'));
		$all = $this->Skpschedule_model->getAll();
		$data = [
			'title' => "Jadwal Ujan Skripsi",
			'content' => 'schedule/skripsi/dosen/dosen',
			'dsn' => $dsn,
			'all' => $all,
		];
		$this->load->view('template/overlay/dosen', $data);
	}


	public function koordinator()
	{
		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$dsn = $this->Skpschedule_model->getDsn($this->session->userdata('user_id'));
		$all = $this->Skpschedule_model->getAll();
		$rooms = $this->Skpschedule_model->getRooms();
		$data = [
			'title' => "Jadwal Ujian Skripsi",
			'content' => 'schedule/skripsi/koordinator/koordinator',
			'dsn' => $dsn,
			'all' => $all,
			'rooms' => $rooms
		];
		$this->load->view('template/overlay/koordinator', $data);
	}

	// public function update()
	// {
	// 	if ($this->session->userdata('group_id') != 3) {
	// 		redirect('error404');
	// 	}

	// 	$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
	// 	$this->form_validation->set_rules('jam', 'Jam', 'required');

	// 	if ($this->form_validation->run() == FALSE || $this->input->post('room_id') == '-- Pilih Ruangan Ujian --') {
	// 		$this->session->set_flashdata('error', 'Semua kolom wajib diisi');
	// 		redirect('schedule_skripsi');
	// 	}

	// 	$id = $this->input->post('id');
	// 	$tanggal = $this->input->post('tanggal');
	// 	$jam = $this->input->post('jam');
	// 	$room = $this->input->post('room_id');
	// 	$data = [
	// 		'tanggal' => $tanggal,
	// 		'jam' => $jam,
	// 		'room_id' => $room
	// 	];

	// 	$this->Skpschedule_model->update($id, $data);

	// 	$this->session->set_flashdata('success', 'Jadwal Ujian Berhasi Diperbarui');
	// 	redirect('schedule_skripsi');
	// }

	//bintang
	public function update()
	{
		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_rules('jam', 'Jam', 'required');

		if ($this->form_validation->run() == FALSE || $this->input->post('room_id') == '-- Pilih Ruangan Ujian --') {
			$this->session->set_flashdata('error', 'Semua kolom wajib diisi');
			redirect('schedule_skripsi');
		}

		$id = $this->input->post('id');
		$tanggal = $this->input->post('tanggal');
		$jam = $this->input->post('jam');
		$room = $this->input->post('room_id');
		$data = [
			'tanggal' => $tanggal,
			'jam' => $jam,
			'room_id' => $room
		];

		$this->Skpschedule_model->update($id, $data);

		$title_id = $this->input->post('title_id');
		// Get mahasiswa and dosen IDs
		$skripsi_data = $this->db->where('id', $title_id)->get('title')->first_row();
		$mahasiswa_id = $skripsi_data->mahasiswa;
		$dospem_1_id = $skripsi_data->dospem_1_id;
		$dospem_2_id = $skripsi_data->dospem_2_id;

		// Insert notification for mahasiswa
		$notif_data = array(
			'user_id' => $mahasiswa_id,
			'judul' => 'Jadwal Ujian Skripsi Diperbarui',
			'pesan' => "Jadwal ujian skripsi Anda telah diperbarui. Silahkan cek jadwal Anda sekarang.",
			'type' => 'info'
		);
		$this->db->insert('notifikasi', $notif_data);

		// Insert notification for Dosen Pembimbing 1
		if ($dospem_1_id) {
			$notif_data = array(
				'user_id' => $dospem_1_id,
				'judul' => 'Jadwal Ujian Skripsi Diperbarui',
				'pesan' => "Jadwal ujian skripsi mahasiswa bimbingan Anda telah diperbarui. Silahkan cek jadwal sekarang.",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		// Insert notification for Dosen Pembimbing 2
		if ($dospem_2_id) {
			$notif_data = array(
				'user_id' => $dospem_2_id,
				'judul' => 'Jadwal Ujian Skripsi Diperbarui',
				'pesan' => "Jadwal ujian skripsi mahasiswa bimbingan Anda telah diperbarui. Silahkan cek jadwal sekarang.",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		$this->session->set_flashdata('success', 'Jadwal Ujian Berhasil Diperbarui');
		redirect('schedule_skripsi');
	}


	public function admin()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$all = $this->Skpschedule_model->getAll();
		$data = [
			'title' => "Jadwal Ujian Skripsi",
			'content' => 'schedule/skripsi/admin/admin',
			'all' => $all,
		];
		$this->load->view('template/overlay/admin', $data);
	}
}
