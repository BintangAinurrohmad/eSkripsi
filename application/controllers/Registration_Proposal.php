<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration_Proposal extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Proregister_model');
		$this->load->model('Notification_model');
		$this->load->library('upload');
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

	public function view_file($folder, $file)
	{
		if (!$this->session->userdata('is_login')) {
			redirect('login');
		} else {
			if ($this->session->userdata('group_id') == 1) {
				$overlay = 'template/overlay/mahasiswa';
			} else if ($this->session->userdata('group_id') == 2) {
				$overlay = 'template/overlay/dosen';
			} else if ($this->session->userdata('group_id') == 3) {
				$overlay = 'template/overlay/koordinator';
			} else if ($this->session->userdata('group_id') == 4) {
				$overlay = 'template/overlay/admin';
			} else {
				redirect('login');
			}
		}

		if ($folder == "persetujuan") {
			$title = "Lembar Persetujuan";
		} else if ($folder == "naskah") {
			$title = "Naskah";
		} else {
			$title = "Berkas";
		}

		$data = [
			'title' => 'Lihat ' . $title,
			'content' => 'registration/proposal/view_file',
			'folder' => $folder,
			'file' => $file
		];
		$this->load->view($overlay, $data);
	}

	public function mahasiswa()
	{
		if ($this->session->userdata('group_id') != 1) {
			redirect('error404');
		}

		$myProposal = $this->Proregister_model->getMyProposal($this->session->userdata('user_id'));
		$data = [
			'title' => "Pendaftaran Ujian Proposal",
			'content' => 'registration/proposal/mahasiswa/mahasiswa',
			'myProposal' => $myProposal
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function daftar()
	{
		if ($this->session->userdata('group_id') != 1) {
			redirect('error404');
		}

		$myTitle = $this->Proregister_model->getMyTitle($this->session->userdata('user_id'));
		$data = [
			'title' => "Pendaftaran Ujian Proposal",
			'content' => 'registration/proposal/mahasiswa/register',
			'myTitle' => $myTitle
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	//bintang
	public function addProposal()
	{
		if ($this->session->userdata('group_id') != 1) {
			redirect('error404');
		}

		if ($this->input->post('title_id') == '-- Pilih Judul --') {
			$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi.');
			redirect('registration_proposal/daftar');
		}

		$this->form_validation->set_rules('title_id', 'Judul', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi.');
			redirect('registration_proposal/daftar');
		} else {
			// Upload naskah
			$config_naskah['upload_path'] = './file/proposal/naskah/';
			$config_naskah['allowed_types'] = 'pdf';
			$config_naskah['max_size'] = 5120; // 5MB

			$this->upload->initialize($config_naskah);

			if (!$this->upload->do_upload('file_naskah')) {
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('registration_proposal/daftar');
			} else {
				$upload_data_naskah = $this->upload->data();
				$file_name_naskah = $upload_data_naskah['file_name'];

				// Upload persetujuan
				$config_persetujuan['upload_path'] = './file/proposal/persetujuan/';
				$config_persetujuan['allowed_types'] = 'pdf';
				$config_persetujuan['max_size'] = 2048; // 2MB

				$this->upload->initialize($config_persetujuan);

				if (!$this->upload->do_upload('file_persetujuan')) {
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect('registration_proposal/daftar');
				} else {
					$upload_data_persetujuan = $this->upload->data();
					$file_name_persetujuan = $upload_data_persetujuan['file_name'];

					$data = array(
						'title_id' => $this->input->post('title_id'),
						'file_naskah' => $file_name_naskah,
						'file_persetujuan' => $file_name_persetujuan,
						'status_dospem_1' => 'Sedang diproses',
						'status_dospem_2' => 'Sedang diproses',
						'status' => 'Sedang diproses'
					);

					$this->Proregister_model->addProposal($data);

					$data2 = [
						'status_ujian_proposal' => 'Terdaftar'
					];

					$this->Proregister_model->setTitle($this->input->post('title_id'), $data2);

					// Get dosen pembimbing and koordinator skripsi (group_id = 4)
					$dospem1 = $this->input->post('dospem1');
					$dospem2 = $this->input->post('dospem2');

					$koordinator_query = $this->db->where('group_id', 4)->get('users');
					$koordinator_list = $koordinator_query->result();

					// Insert notifications
					$notif_data = [];

					if ($dospem1) {
						$notif_data[] = array(
							'user_id' => $dospem1,
							'judul' => 'Pengajuan Seminar Proposal Baru',
							'pesan' => "Ada pengajuan seminar proposal baru dari mahasiswa bimbingan Anda.",
							'type' => 'info'
						);
					}

					if ($dospem2) {
						$notif_data[] = array(
							'user_id' => $dospem2,
							'judul' => 'Pengajuan Seminar Proposal Baru',
							'pesan' => "Ada pengajuan seminar proposal baru dari mahasiswa bimbingan Anda.",
							'type' => 'info'
						);
					}

					foreach ($koordinator_list as $koordinator) {
						$notif_data[] = array(
							'user_id' => $koordinator->id,
							'judul' => 'Pengajuan Seminar Proposal Baru',
							'pesan' => "Ada pengajuan seminar proposal baru yang perlu diperiksa.",
							'type' => 'info'
						);
					}

					if (!empty($notif_data)) {
						$this->db->insert_batch('notifikasi', $notif_data);
					}

					$this->session->set_flashdata('success', 'Berhasil mendaftar ujian proposal');
					redirect('registration_proposal');
				}
			}
		}
	}


	public function dosen()
	{
		if ($this->session->userdata('group_id') != 2) {
			redirect('error404');
		}

		$dospem1 = $this->Proregister_model->getProposalDospem1($this->session->userdata('user_id'));
		$dospem2 = $this->Proregister_model->getProposalDospem2($this->session->userdata('user_id'));
		$data = [
			'title' => "Pendaftaran Ujian Proposal",
			'content' => 'registration/proposal/dosen/dosen',
			'dospem1' => $dospem1,
			'dospem2' => $dospem2,
		];

		// var_export($data['dospem2'][2]);
		// die;
		$this->load->view('template/overlay/dosen', $data);
	}

	public function update_status_dospem1($id)
	{
		$status = $this->input->post('status');
		if (!empty($status)) {
			$data['status_dospem_1'] = $status;
			$this->Proregister_model->accProposal($id, $data);
		}
		redirect("registration_proposal");
	}

	public function update_status_dospem2($id)
	{
		$status = $this->input->post('status');
		if (!empty($status)) {
			$data['status_dospem_2'] = $status;
			$this->Proregister_model->accProposal($id, $data);
		}
		redirect("registration_proposal");
	}

	public function koordinator()
	{
		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$dosuji1 = $this->Proregister_model->getDosen();
		$dosuji2 = $this->Proregister_model->getDosen();
		$dospem1 = $this->Proregister_model->getProposalDospem1($this->session->userdata('user_id'));
		$dospem2 = $this->Proregister_model->getProposalDospem2($this->session->userdata('user_id'));
		$koordinator = $this->Proregister_model->getProposalKoo($this->session->userdata('user_id'));
		$rooms = $this->Proregister_model->getRooms();
		$data = [
			'title' => "Pendaftaran Ujian Proposal",
			'content' => 'registration/proposal/koordinator/koordinator',
			'dospem1' => $dospem1,
			'dospem2' => $dospem2,
			'koordinator' => $koordinator,
			'rooms' => $rooms,
			'dosuji1' => $dosuji1,
			'dosuji2' => $dosuji2
		];
		$this->load->view('template/overlay/koordinator', $data);
	}


	//edit bintang
	public function accProposal()
	{
		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_rules('jam', 'Jam', 'required');

		if ($this->form_validation->run() == FALSE || $this->input->post('room_id') == '-- Pilih Ruangan Ujian --' || $this->input->post('dosuji1') == '-- Pilih Penguji 1 --' || $this->input->post('dosuji2') == '-- Pilih Penguji 2 --') {
			$this->session->set_flashdata('error', 'Silahkan atur jadwal dan tempat ujian untuk menyetujui pendaftaran.');
			redirect('registration_proposal');
		}

		$id_register = $this->input->post('id');
		$tanggal = $this->input->post('tanggal');
		$jam = $this->input->post('jam');
		$room = $this->input->post('room_id');
		$data = [
			'status' => 'Diterima',
			'tanggal' => $tanggal,
			'jam' => $jam,
			'room_id' => $room
		];

		$this->Proregister_model->accProposal($id_register, $data);

		$title_id = $this->input->post('title_id');
		$dosuji1 = $this->input->post('dosuji1');
		$dosuji2 = $this->input->post('dosuji2');
		$data2 = [
			'dosuji_1_id' => $dosuji1,
			'dosuji_2_id' => $dosuji2,
		];
		$this->Proregister_model->setDosuji($title_id, $data2);

		$dospem1 = $this->input->post('dospem1');
		$dospem2 = $this->input->post('dospem2');

		$data_ujian_1 = [
			'pro_register_id' => $id_register,
			'dosen_id' => $dospem1,
			'as' => 'dospem-1'
		];
		$this->Proregister_model->addUjian($data_ujian_1);

		$data_ujian_2 = [
			'pro_register_id' => $id_register,
			'dosen_id' => $dospem2,
			'as' => 'dospem-2'
		];
		$this->Proregister_model->addUjian($data_ujian_2);

		$data_ujian_3 = [
			'pro_register_id' => $id_register,
			'dosen_id' => $dosuji1,
			'as' => 'dosuji-1'
		];
		$this->Proregister_model->addUjian($data_ujian_3);

		$data_ujian_4 = [
			'pro_register_id' => $id_register,
			'dosen_id' => $dosuji2,
			'as' => 'dosuji-2'
		];
		$this->Proregister_model->addUjian($data_ujian_4);

		//edit bintang
		// Get mahasiswa ID
		$title_data = $this->db->where('id', $title_id)->get('title')->first_row();
		$mahasiswa_id = $title_data->mahasiswa;

		// Insert notification for mahasiswa
		$notif_data = array(
			'user_id' => $mahasiswa_id,
			'judul' => 'Pengajuan Seminar Proposal Diterima',
			'pesan' => "Silahkan cek jadwal anda sekarang",
			'type' => 'success'
		);
		$this->db->insert('notifikasi', $notif_data);

		// Insert notification for Dosen Pembimbing 1
		if ($dospem1) {
			$notif_data = array(
				'user_id' => $dospem1,
				'judul' => 'Pengajuan Seminar Proposal Diterima',
				'pesan' => "Silahkan cek jadwal mahasiswa bimbingan Anda sekarang",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		// Insert notification for Dosen Pembimbing 2
		if ($dospem2) {
			$notif_data = array(
				'user_id' => $dospem2,
				'judul' => 'Pengajuan Seminar Proposal Diterima',
				'pesan' => "Silahkan cek jadwal mahasiswa bimbingan Anda sekarang",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		// Insert notification for Dosen Penguji 1
		if ($dosuji1) {
			$notif_data = array(
				'user_id' => $dosuji1,
				'judul' => 'Pengajuan Seminar Proposal Diterima',
				'pesan' => "Silahkan cek jadwal ujian proposal yang akan Anda uji",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		// Insert notification for Dosen Penguji 2
		if ($dosuji2) {
			$notif_data = array(
				'user_id' => $dosuji2,
				'judul' => 'Pengajuan Seminar Proposal Diterima',
				'pesan' => "Silahkan cek jadwal ujian proposal yang akan Anda uji",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		$this->session->set_flashdata('success', 'Pendaftaran Ujian Proposal Berhasil Disetujui');
		redirect('registration_proposal');
	}


	public function deProposal($id)
	{
		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$data['status'] = 'Ditolak';
		$this->Proregister_model->accProposal($id, $data);

		$thisProposal = $this->Proregister_model->getThisProposal($id);
		$data2 = [
			'status_ujian_proposal' => 'Belum terdaftar'
		];
		$this->Proregister_model->setTitle($thisProposal->title_id, $data2);

		// Retrieve mahasiswa and dosen IDs
		$titleData = $this->db->where('id', $thisProposal->title_id)->get('title')->first_row();
		$mahasiswa_id = $titleData->mahasiswa;
		$dospem_1_id = $titleData->dospem_1_id;
		$dospem_2_id = $titleData->dospem_2_id;

		// Insert notification for mahasiswa
		$notif_data = array(
			'user_id' => $mahasiswa_id,
			'judul' => 'Pengajuan Seminar Proposal Ditolak',
			'pesan' => "Silahkan cek jadwal anda sekarang",
			'type' => 'success'
		);
		$this->db->insert('notifikasi', $notif_data);

		// Insert notification for Dosen Pembimbing 1
		if ($dospem_1_id) {
			$notif_data = array(
				'user_id' => $dospem_1_id,
				'judul' => 'Pengajuan Seminar Proposal Ditolak',
				'pesan' => "Silahkan cek status pengajuan seminar proposal mahasiswa bimbingan Anda",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		// Insert notification for Dosen Pembimbing 2
		if ($dospem_2_id) {
			$notif_data = array(
				'user_id' => $dospem_2_id,
				'judul' => 'Pengajuan Seminar Proposal Ditolak',
				'pesan' => "Silahkan cek status pengajuan seminar proposal mahasiswa bimbingan Anda",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		$this->session->set_flashdata('denied', 'Judul Berhasil Ditolak');
		redirect('registration_proposal');
	}


	public function admin()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$proposal = $this->Proregister_model->getProposal();
		$data = [
			'title' => "Pendaftaran Ujian Proposal",
			'content' => 'registration/proposal/admin/admin',
			'proposal' => $proposal,
		];
		$this->load->view('template/overlay/admin', $data);
	}

	// public function admin2()
	// {
	// 	$data = [
	// 		'title' => "Pendaftaran Ujian Proposal",
	// 		'content' => 'registration/proposal/admin/admin2',
	// 	];
	// 	$this->load->view('template/overlay/admin', $data);
	// }

	// public function admin3()
	// {
	// 	$data = [
	// 		'title' => "Pendaftaran Ujian Proposal",
	// 		'content' => 'registration/proposal/admin/admin3',
	// 	];
	// 	$this->load->view('template/overlay/admin', $data);
	// }
}
