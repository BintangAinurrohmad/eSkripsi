<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration_Skripsi extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Skpregister_model');
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

		if ($folder == "ukt") {
			$title = "Bukti Pembayaran";
		} else if ($folder == "transkrip") {
			$title = "Transkrip Nilai";
		} else if ($folder == "naskah") {
			$title = "Naskah";
		} else if ($folder == "persetujuan") {
			$title = "Lembar Persetujuan";
		} else {
			$title = "Berkas";
		}

		$data = [
			'title' => 'Lihat ' . $title,
			'content' => 'registration/skripsi/view_file',
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

		$mySkripsi = $this->Skpregister_model->getMySkripsi($this->session->userdata('user_id'));
		$hasApprovedTitle = $this->Skpregister_model->has_approved_title($this->session->userdata('user_id'));
		$data = [
			'title' => "Pendaftaran Ujian Skripsi",
			'content' => 'registration/skripsi/mahasiswa/mahasiswa',
			'mySkripsi' => $mySkripsi,
			'hasApprovedTitle' => $hasApprovedTitle
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function daftar()
	{
		if ($this->session->userdata('group_id') != 1) {
			redirect('error404');
		}

		$myTitle = $this->Skpregister_model->getMyTitle($this->session->userdata('user_id'));
		$data = [
			'title' => "Pendaftaran Ujian Skripsi",
			'content' => 'registration/skripsi/mahasiswa/register',
			'myTitle' => $myTitle
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	//bintang
	public function addSkripsi()
	{
		if ($this->session->userdata('group_id') != 1) {
			redirect('error404');
		}

		if ($this->input->post('title_id') == '-- Pilih Judul --') {
			$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi.');
			redirect('registration_skripsi/daftar');
		}

		$this->form_validation->set_rules('title_id', 'Judul', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi.');
			redirect('registration_skripsi/daftar');
		} else {
			// Fungsi untuk mengupload file
			$upload_file = function ($field_name, $upload_path, $max_size) {
				// Ensure the directory exists
				if (!is_dir($upload_path)) {
					mkdir($upload_path, 0777, true);
				}

				$config = [
					'upload_path' => $upload_path,
					'allowed_types' => 'pdf',
					'max_size' => $max_size
				];
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload($field_name)) {
					return ['error' => $this->upload->display_errors()];
				} else {
					return ['success' => $this->upload->data()];
				}
			};

			// Upload file naskah (max 5MB)
			$result_naskah = $upload_file('file_naskah', './file/skripsi/naskah/', 5120);
			if (isset($result_naskah['error'])) {
				$this->session->set_flashdata('error', $result_naskah['error']);
				redirect('registration_skripsi/daftar');
			}
			$file_name_naskah = $result_naskah['success']['file_name'];

			// Upload file ukt (max 2MB)
			$result_ukt = $upload_file('file_ukt', './file/skripsi/ukt/', 2048);
			if (isset($result_ukt['error'])) {
				$this->session->set_flashdata('error', $result_ukt['error']);
				redirect('registration_skripsi/daftar');
			}
			$file_name_ukt = $result_ukt['success']['file_name'];

			// Upload file transkrip (max 2MB)
			$result_transkrip = $upload_file('file_transkrip', './file/skripsi/transkrip/', 2048);
			if (isset($result_transkrip['error'])) {
				$this->session->set_flashdata('error', $result_transkrip['error']);
				redirect('registration_skripsi/daftar');
			}
			$file_name_transkrip = $result_transkrip['success']['file_name'];

			// Upload file persetujuan (max 2MB)
			$result_persetujuan = $upload_file('file_persetujuan', './file/skripsi/persetujuan/', 2048);
			if (isset($result_persetujuan['error'])) {
				$this->session->set_flashdata('error', $result_persetujuan['error']);
				redirect('registration_skripsi/daftar');
			}
			$file_name_persetujuan = $result_persetujuan['success']['file_name'];

			// Data untuk disimpan
			$data = [
				'title_id' => $this->input->post('title_id'),
				'file_naskah' => $file_name_naskah,
				'file_ukt' => $file_name_ukt,
				'file_transkrip' => $file_name_transkrip,
				'file_persetujuan' => $file_name_persetujuan,
				'status_dospem_1' => 'Sedang diproses',
				'status_dospem_2' => 'Sedang diproses',
				'status' => 'Sedang diproses'
			];

			$this->Skpregister_model->addSkripsi($data);

			$data2 = [
				'status_ujian_skripsi' => 'Terdaftar'
			];

			$this->Skpregister_model->setTitle($this->input->post('title_id'), $data2);

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
					'judul' => 'Pengajuan Seminar Skripsi Baru',
					'pesan' => "Ada pengajuan seminar skripsi baru dari mahasiswa bimbingan Anda.",
					'type' => 'info'
				);
			}

			if ($dospem2) {
				$notif_data[] = array(
					'user_id' => $dospem2,
					'judul' => 'Pengajuan Seminar Skripsi Baru',
					'pesan' => "Ada pengajuan seminar skripsi baru dari mahasiswa bimbingan Anda.",
					'type' => 'info'
				);
			}

			foreach ($koordinator_list as $koordinator) {
				$notif_data[] = array(
					'user_id' => $koordinator->id,
					'judul' => 'Pengajuan Seminar Skripsi Baru',
					'pesan' => "Ada pengajuan seminar skripsi baru yang perlu diperiksa.",
					'type' => 'info'
				);
			}

			if (!empty($notif_data)) {
				$this->db->insert_batch('notifikasi', $notif_data);
			}

			$this->session->set_flashdata('success', 'Berhasil mendaftar ujian skripsi');
			redirect('registration_skripsi');
		}
	}

	
	public function dosen()
	{
		if ($this->session->userdata('group_id') != 2) {
			redirect('error404');
		}

		$dospem1 = $this->Skpregister_model->getSkripsiDospem1($this->session->userdata('user_id'));
		$dospem2 = $this->Skpregister_model->getSkripsiDospem2($this->session->userdata('user_id'));
		$data = [
			'title' => "Pendaftaran Ujian Skripsi",
			'content' => 'registration/skripsi/dosen/dosen',
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
			$this->Skpregister_model->accSkripsi($id, $data);
		}
		redirect("registration_skripsi");
	}

	public function update_status_dospem2($id)
	{
		$status = $this->input->post('status');
		if (!empty($status)) {
			$data['status_dospem_2'] = $status;
			$this->Skpregister_model->accSkripsi($id, $data);
		}
		redirect("registration_skripsi");
	}



	public function koordinator()
	{
		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$dospem1 = $this->Skpregister_model->getSkripsiDospem1($this->session->userdata('user_id'));
		$dospem2 = $this->Skpregister_model->getSkripsiDospem2($this->session->userdata('user_id'));
		$koordinator = $this->Skpregister_model->getSkripsiKoo($this->session->userdata('user_id'));
		$rooms = $this->Skpregister_model->getRooms();
		$data = [
			'title' => "Pendaftaran Ujian Skripsi",
			'content' => 'registration/skripsi/koordinator/koordinator',
			'dospem1' => $dospem1,
			'dospem2' => $dospem2,
			'koordinator' => $koordinator,
			'rooms' => $rooms,
		];
		$this->load->view('template/overlay/koordinator', $data);
	}

	// public function accSkripsi()
	// {
	// 	if ($this->session->userdata('group_id') != 3) {
	// 		redirect('error404');
	// 	}

	// 	$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
	// 	$this->form_validation->set_rules('jam', 'Jam', 'required');

	// 	if ($this->form_validation->run() == FALSE || $this->input->post('room_id') == '-- Pilih Ruangan Ujian --') {
	// 		$this->session->set_flashdata('error', 'Silahkan atur jadwal dan tempat ujian untuk menyetujui pendaftaran.');
	// 		redirect('registration_proposal');
	// 	}

	// 	$id_register = $this->input->post('id');
	// 	$tanggal = $this->input->post('tanggal');
	// 	$jam = $this->input->post('jam');
	// 	$room = $this->input->post('room_id');
	// 	$data = [
	// 		'status' => 'Diterima',
	// 		'tanggal' => $tanggal,
	// 		'jam' => $jam,
	// 		'room_id' => $room
	// 	];
	// 	$this->Skpregister_model->accSkripsi($id_register, $data);

	// 	$dospem1 = $this->input->post('dospem1');
	// 	$dospem2 = $this->input->post('dospem2');
	// 	$dosuji1 = $this->input->post('dosuji1');
	// 	$dosuji2 = $this->input->post('dosuji2');

	// 	$data_ujian_1 = [
	// 		'skp_register_id' => $id_register,
	// 		'dosen_id' => $dospem1,
	// 		'as' => 'dospem-1'
	// 	];
	// 	$this->Skpregister_model->addUjian($data_ujian_1);

	// 	$data_ujian_2 = [
	// 		'skp_register_id' => $id_register,
	// 		'dosen_id' => $dospem2,
	// 		'as' => 'dospem-2'
	// 	];
	// 	$this->Skpregister_model->addUjian($data_ujian_2);

	// 	$data_ujian_3 = [
	// 		'skp_register_id' => $id_register,
	// 		'dosen_id' => $dosuji1,
	// 		'as' => 'dosuji-1'
	// 	];
	// 	$this->Skpregister_model->addUjian($data_ujian_3);

	// 	$data_ujian_4 = [
	// 		'skp_register_id' => $id_register,
	// 		'dosen_id' => $dosuji2,
	// 		'as' => 'dosuji-2'
	// 	];
	// 	$this->Skpregister_model->addUjian($data_ujian_4);

	// 	$this->session->set_flashdata('success', 'Pendaftaran Ujian Proposal Berhasil Disetujui');
	// 	redirect('registration_skripsi');
	// }

	// public function deSkripsi($id)
	// {
	// 	if ($this->session->userdata('group_id') != 3) {
	// 		redirect('error404');
	// 	}

	// 	$data['status'] = 'Ditolak';
	// 	$this->Skpregister_model->accSkripsi($id, $data);

	// 	$thisSkripsi = $this->Skpregister_model->getThisSkripsi($id);
	// 	$data2 = [
	// 		'status_ujian_skripsi' => 'Belum terdaftar'
	// 	];
	// 	$this->Skpregister_model->setTitle($thisSkripsi->title_id, $data2);

	// 	$this->session->set_flashdata('denied', 'Judul Berhasil Ditolak');
	// 	redirect('registration_skripsi');
	// }

	//bintang
	public function accSkripsi()
	{
		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_rules('jam', 'Jam', 'required');

		if ($this->form_validation->run() == FALSE || $this->input->post('room_id') == '-- Pilih Ruangan Ujian --') {
			$this->session->set_flashdata('error', 'Silahkan atur jadwal dan tempat ujian untuk menyetujui pendaftaran.');
			redirect('registration_skripsi');
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
		$this->Skpregister_model->accSkripsi($id_register, $data);

		$dospem1 = $this->input->post('dospem1');
		$dospem2 = $this->input->post('dospem2');
		$dosuji1 = $this->input->post('dosuji1');
		$dosuji2 = $this->input->post('dosuji2');

		$data_ujian_1 = [
			'skp_register_id' => $id_register,
			'dosen_id' => $dospem1,
			'as' => 'dospem-1'
		];
		$this->Skpregister_model->addUjian($data_ujian_1);

		$data_ujian_2 = [
			'skp_register_id' => $id_register,
			'dosen_id' => $dospem2,
			'as' => 'dospem-2'
		];
		$this->Skpregister_model->addUjian($data_ujian_2);

		$data_ujian_3 = [
			'skp_register_id' => $id_register,
			'dosen_id' => $dosuji1,
			'as' => 'dosuji-1'
		];
		$this->Skpregister_model->addUjian($data_ujian_3);

		$data_ujian_4 = [
			'skp_register_id' => $id_register,
			'dosen_id' => $dosuji2,
			'as' => 'dosuji-2'
		];
		$this->Skpregister_model->addUjian($data_ujian_4);

		// Get mahasiswa ID
		$title_data = $this->db->where('id', $title_id)->get('title')->first_row();
		$mahasiswa_id = $title_data->mahasiswa;

		// Insert notification for mahasiswa
		$notif_data = array(
			'user_id' => $mahasiswa_id,
			'judul' => 'Pengajuan Skripsi Diterima',
			'pesan' => "Silahkan cek jadwal anda sekarang",
			'type' => 'success'
		);
		$this->db->insert('notifikasi', $notif_data);

		// Insert notification for Dosen Pembimbing 1
		if ($dospem1) {
			$notif_data = array(
				'user_id' => $dospem1,
				'judul' => 'Pengajuan Skripsi Diterima',
				'pesan' => "Silahkan cek jadwal mahasiswa bimbingan Anda sekarang",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		// Insert notification for Dosen Pembimbing 2
		if ($dospem2) {
			$notif_data = array(
				'user_id' => $dospem2,
				'judul' => 'Pengajuan Skripsi Diterima',
				'pesan' => "Silahkan cek jadwal mahasiswa bimbingan Anda sekarang",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		// Insert notification for Dosen Penguji 1
		if ($dosuji1) {
			$notif_data = array(
				'user_id' => $dosuji1,
				'judul' => 'Pengajuan Skripsi Diterima',
				'pesan' => "Silahkan cek jadwal ujian skripsi yang akan Anda ujikan",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		// Insert notification for Dosen Penguji 2
		if ($dosuji2) {
			$notif_data = array(
				'user_id' => $dosuji2,
				'judul' => 'Pengajuan Skripsi Diterima',
				'pesan' => "Silahkan cek jadwal ujian skripsi yang akan Anda ujikan",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		$this->session->set_flashdata('success', 'Pendaftaran Ujian Skripsi Berhasil Disetujui');
		redirect('registration_skripsi');
	}

	public function deSkripsi($id)
	{
		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$data['status'] = 'Ditolak';
		$this->Skpregister_model->accSkripsi($id, $data);

		$thisSkripsi = $this->Skpregister_model->getThisSkripsi($id);
		$data2 = [
			'status_ujian_skripsi' => 'Belum terdaftar'
		];
		$this->Skpregister_model->setTitle($thisSkripsi->title_id, $data2);

		// Retrieve mahasiswa and dosen IDs
		$titleData = $this->db->where('id', $thisSkripsi->title_id)->get('title')->first_row();
		$mahasiswa_id = $titleData->mahasiswa;
		$dospem_1_id = $titleData->dospem_1_id;
		$dospem_2_id = $titleData->dospem_2_id;

		// Insert notification for mahasiswa
		$notif_data = array(
			'user_id' => $mahasiswa_id,
			'judul' => 'Pengajuan Skripsi Ditolak',
			'pesan' => "Silahkan cek jadwal anda sekarang",
			'type' => 'success'
		);
		$this->db->insert('notifikasi', $notif_data);

		// Insert notification for Dosen Pembimbing 1
		if ($dospem_1_id) {
			$notif_data = array(
				'user_id' => $dospem_1_id,
				'judul' => 'Pengajuan Skripsi Ditolak',
				'pesan' => "Silahkan cek status pengajuan skripsi mahasiswa bimbingan Anda",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		// Insert notification for Dosen Pembimbing 2
		if ($dospem_2_id) {
			$notif_data = array(
				'user_id' => $dospem_2_id,
				'judul' => 'Pengajuan Skripsi Ditolak',
				'pesan' => "Silahkan cek status pengajuan skripsi mahasiswa bimbingan Anda",
				'type' => 'info'
			);
			$this->db->insert('notifikasi', $notif_data);
		}

		$this->session->set_flashdata('denied', 'Judul Berhasil Ditolak');
		redirect('registration_skripsi');
	}


	public function admin()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$skripsi = $this->Skpregister_model->getProposal();
		$data = [
			'title' => "Pendaftaran Ujian Skripsi",
			'content' => 'registration/skripsi/admin/admin',
			'proposal' => $skripsi,
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
