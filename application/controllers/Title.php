<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Title extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Title_model');
		$this->load->model('Notification_model');
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

		$myt = $this->Title_model->getMyTitle($this->session->userdata('user_id'));
		$title = $this->Title_model->getTitle();
		$data = [
			'title' => "Pengajuan Judul",
			'content' => 'title/mahasiswa/mahasiswa',
			't' => $title,
			'myt' => $myt
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function mahasiswa2()
	{
		if ($this->session->userdata('group_id') != 1) {
			redirect('error404');
		}

		$research_area = $this->Title_model->getResearchArea();
		$dosen = $this->Title_model->getDosen();
		$dosen2 = $this->Title_model->getDosen();
		$data = [
			'title' => "Pengajuan Judul",
			'content' => 'title/mahasiswa/mahasiswa2',
			'research_area' => $research_area,
			'dosen' => $dosen,
			'dosen2' => $dosen2
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}


	//bintang
	public function addTitle()
	{
		$user = $this->db->get_where('users', ['id' => $this->session->userdata('user_id')])->row_array();

		$this->form_validation->set_rules('judul', 'Judul', 'required');
		$this->form_validation->set_rules('bidang_id', 'Bidang', 'required');
		$this->form_validation->set_rules('dospem_1_id', 'Dosen Pembimbing 1', 'required');
		$this->form_validation->set_rules('dospem_2_id', 'Dosen Pembimbing 2', 'required');

		// If validation fails
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi.');
			redirect('title/mahasiswa2');
		} else {
			// If validation succeeds, save data to database
			$data = [
				'judul' => $this->input->post('judul'),
				'mahasiswa' => $user['id'],
				'tanggal_pengajuan' => date('Y-m-d H:i:s'),
				'bidang_id' => $this->input->post('bidang_id'),
				'dospem_1_id' => $this->input->post('dospem_1_id'),
				'status_dospem_1' => 'Sedang Diproses',
				'dospem_2_id' => $this->input->post('dospem_2_id'),
				'status_dospem_2' => 'Sedang Diproses',
				'status' => 'Sedang Diproses'
			];

			if ($data['bidang_id'] == 'Pilih Bidang' || $data['dospem_1_id'] == 'Pilih Dosen' || $data['dospem_2_id'] == 'Pilih Dosen') {
				$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi.');
				redirect('title/mahasiswa2');
			}

			$this->Title_model->addTitle($data);

			// Get dosen pembimbing and koordinator skripsi (group_id = 3)

			$dospem1 = $this->input->post('dospem_1_id');
			$dospem2 = $this->input->post('dospem_2_id');

			$koordinator_query = $this->db->where('group_id', 3)->get('users');
			$koordinator_list = $koordinator_query->result();


			// Insert notifications 
			$notif_data = [];

			if ($dospem1) {
				$notif_data[] = [
					'user_id' => $dospem1,
					'judul' => 'Pengajuan Judul Skripsi Baru',
					'pesan' => "Ada pengajuan judul skripsi baru dari mahasiswa bimbingan Anda.",
					'type' => 'info',
					//13/08 insert notif
					'page_type' => 'title-submission'
				];
			}

			if ($dospem2) {
				$notif_data[] = [
					'user_id' => $dospem2,
					'judul' => 'Pengajuan Judul Skripsi Baru',
					'pesan' => "Ada pengajuan judul skripsi baru dari mahasiswa bimbingan Anda.",
					'type' => 'info',
					'page_type' => 'title-submission'
				];
			}

			foreach ($koordinator_list as $koordinator) {
				$notif_data[] = [
					'user_id' => $koordinator->id,
					'judul' => 'Pengajuan Judul Skripsi Baru',
					'pesan' => "Ada pengajuan judul skripsi baru yang perlu direspon.",
					'type' => 'info',
					'page_type' => 'title-submission'
				];
			}

			if (!empty($notif_data)) {
				$this->db->insert_batch('notifikasi', $notif_data);
			}

			$this->session->set_flashdata('success', 'Berhasil mengajukan judul. Silahkan tunggu untuk judul disetujui oleh dosen pembimbing yang telah anda pilih!');
			redirect('title');
		}
	}


	public function dosen()
	{
		if ($this->session->userdata('group_id') != 2) {
			redirect('error404');
		}

		$id = $this->session->userdata('user_id');
		$dospem1 = $this->Title_model->getTitleDospem1($id);
		$dospem2 = $this->Title_model->getTitleDospem2($id);
		$t = $this->Title_model->getAllTitleDosen($id);
		$data = [
			'title' => "Pengajuan Judul",
			'content' => 'title/dosen/dosen',
			'dospem1' => $dospem1,
			'dospem2' => $dospem2,
			't' => $t
		];
		$this->load->view('template/overlay/dosen', $data);
	}

	public function accDospem1()
	{
		$id = $this->input->post('id');
		$data['status_dospem_1'] = 'Diterima';
		$this->Title_model->accTitle($id, $data);

		$this->session->set_flashdata('success', 'Judul Berhasil Disetujui');
		redirect('title');
	}

	public function deDospem1()
	{
		$id = $this->input->post('id');
		$alasan = $this->input->post('alasan');
		$data = [
			'status_dospem_1' => 'Ditolak',
			'alasan_dospem_1' => $alasan
		];
		$this->Title_model->accTitle($id, $data);

		$this->session->set_flashdata('denied', 'Judul Berhasil Ditolak');
		redirect('title');
	}

	public function accDospem2()
	{
		$id = $this->input->post('id');
		$data['status_dospem_2'] = 'Diterima';
		$this->Title_model->accTitle($id, $data);

		$this->session->set_flashdata('success', 'Judul Berhasil Disetujui');
		redirect('title');
	}

	public function deDospem2()
	{
		$id = $this->input->post('id');
		$alasan = $this->input->post('alasan');
		$data = [
			'status_dospem_2' => 'Ditolak',
			'alasan_dospem_2' => $alasan
		];
		$this->Title_model->accTitle($id, $data);

		$this->session->set_flashdata('denied', 'Judul Berhasil Ditolak');
		redirect('title');
	}

	public function koordinator()
	{
		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$id = $this->session->userdata('user_id');
		$dospem1 = $this->Title_model->getTitleDospem1($id);
		$dospem2 = $this->Title_model->getTitleDospem2($id);
		$titleKo = $this->Title_model->getTitleKo();
		$dosen = $this->Title_model->getDosen();
		$t = $this->Title_model->getTitle();
		$data = [
			'title' => "Pengajuan Judul",
			'content' => 'title/koordinator/koordinator',
			'titleKo' => $titleKo,
			'dospem1' => $dospem1,
			'dospem2' => $dospem2,
			'dosen' => $dosen,
			't' => $t
		];
		$this->load->view('template/overlay/koordinator', $data);
	}


	//edit bintang
	public function accTitle()
	{
		$id = $this->input->post('id');
		$data['status'] = 'Diterima';
		$this->Title_model->accTitle($id, $data);

		$data['mytitle'] = $this->Title_model->getMyTitleById($id);
		$mahasiswa_id = $data['mytitle'][0]->mahasiswa;

		// Insert new notification
		$notif_data = array(
			'user_id' => $mahasiswa_id,
			'judul' => 'Judul Diterima',
			'pesan' => "Judul anda telah diterima",
			'type' => 'success', // or any other type you want,
			'page_type' => 'approved_title'
		);
		$this->db->insert('notifikasi', $notif_data);

		$this->session->set_flashdata('success', 'Judul Berhasil Disetujui');
		redirect('title');
	}

	//bintang
	public function accTitle2()
	{
		if ($this->input->post('dospem2') == '-- Pilih Dosen --') {
			$this->session->set_flashdata('error', 'Silahkan atur dosen pembimbing 2 pengganti');
			redirect('title');
		}

		$id = $this->input->post('id');
		$data['status'] = 'Diterima';
		$data['dospem_2_id'] = $this->input->post('dospem2');
		$data['alasan_dospem_2'] = '';
		$data['status_dospem_2'] = 'Diterima';
		$this->Title_model->accTitle($id, $data);

		$data['mytitle'] = $this->Title_model->getMyTitleById($id);
		$mahasiswa_id = $data['mytitle'][0]->mahasiswa;

		// Insert new notification
		$notif_data = array(
			'user_id' => $mahasiswa_id,
			'judul' => 'Judul Diterima',
			'pesan' => "Judul anda telah diterima",
			'type' => 'success', // or any other type you want
			'page_type' => 'approved_title'
		);
		$this->db->insert('notifikasi', $notif_data);

		$this->session->set_flashdata('success', 'Judul Berhasil Disetujui');
		redirect('title');
	}

	public function deTitle()
	{
		$id = $this->input->post('id');
		$data['status'] = 'Ditolak';
		$this->Title_model->accTitle($id, $data);

		//bintang
		$data['mytitle'] = $this->Title_model->getMyTitleById($id);
		$mahasiswa_id = $data['mytitle'][0]->mahasiswa;

		// Insert new notification
		$notif_data = array(
			'user_id' => $mahasiswa_id,
			'judul' => 'Judul Ditolak',
			'pesan' => "Judul anda telah ditolak",
			'type' => 'success', // or any other type you want
			'page_type' => 'rejected_title'
		);
		$this->db->insert('notifikasi', $notif_data);

		$this->session->set_flashdata('denied', 'Judul Berhasil Ditolak');
		redirect('title');
	}

	public function edit_title($title_id)
	{
		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$research_area = $this->Title_model->getResearchArea();
		$dosen = $this->Title_model->getDosen();
		$dosen2 = $this->Title_model->getDosen();
		$judul = $this->Title_model->getThisTitle($title_id);
		$data = [
			'title' => "Sunting Judul",
			'content' => 'title/koordinator/koordinator2',
			'research_area' => $research_area,
			'dosen' => $dosen,
			'dosen2' => $dosen2,
			'judul' => $judul
		];
		$this->load->view('template/overlay/koordinator', $data);
	}

	public function set_title()
	{

		$user = $this->db->get_where('users', ['id' => $this->session->userdata('user_id')])->row_array();

		$this->form_validation->set_rules('judul', 'Judul', 'required');
		$this->form_validation->set_rules('bidang_id', 'Bidang', 'required');
		$this->form_validation->set_rules('dospem_1_id', 'Dosen Pembimbing 1', 'required');
		$this->form_validation->set_rules('dospem_2_id', 'Dosen Pembimbing 2', 'required');

		// If validation fails
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi.');
			redirect('title/edit_title');
		} else {
			// If validation succeeds, save data to database
			$data['judul'] = $this->input->post('judul');
			$data['bidang_id'] = $this->input->post('bidang_id');
			$data['dospem_1_id'] = $this->input->post('dospem_1_id');
			$data['dospem_2_id'] = $this->input->post('dospem_2_id');

			$inStatus = $this->input->post('title_status');
			if ($inStatus == "Diterima") {
				$data['status_dospem_1'] = "Diterima";
				$data['status_dospem_2'] = "Diterima";
				$data['status'] = "Diterima";
			} else if ($inStatus == "Ditolak") {
				$data['status_dospem_1'] = "Ditolak";
				$data['status_dospem_2'] = "Ditolak";
				$data['status'] = "Ditolak";
			} else {
				$data['status_dospem_1'] = "Sedang diproses";
				$data['status_dospem_2'] = "Sedang diproses";
				$data['status'] = "Sedang diproses";
			}

			$title_id = $this->input->post('title_id');

			$this->Title_model->editTitle($title_id, $data);

			$this->session->set_flashdata('success', 'Berhasil menyunting judul');
			redirect('title');
		}
	}

	public function admin()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$titles = $this->Title_model->getTitle();
		$data = [
			'title' => "Pengajuan Judul",
			'content' => 'title/admin/admin',
			'titles' => $titles
		];
		$this->load->view('template/overlay/admin', $data);
	}
}
