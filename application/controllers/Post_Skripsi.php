<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post_Skripsi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Skppasca_model');
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

	public function view_naskah($file_naskah)
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

		$data = [
			'title' => "Naskah Skripsi",
			'content' => 'post/skripsi/view_naskah',
			'file_naskah' => $file_naskah
		];
		$this->load->view($overlay, $data);
	}

	public function mahasiswa()
	{
		$judul = $this->Skppasca_model->get_title($this->session->userdata('user_id'));

		if ($judul) {
			$content = 'post/skripsi/mahasiswa/mahasiswa';
		} else {
			$content = 'post/skripsi/mahasiswa/mahasiswa2';
		}

		$data = [
			'title' => "Pasca Ujian Skripsi",
			'content' => $content,
			'judul' => $judul,
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function upload()
	{
		// Konfigurasi upload file naskah
		$config_naskah['upload_path'] = './file/skripsi/naskah_final';
		$config_naskah['allowed_types'] = 'pdf';
		$config_naskah['max_size'] = 10240; // 10MB

		$this->load->library('upload', $config_naskah);

		if (!$this->upload->do_upload('skripsi_final')) {
			$error = $this->upload->display_errors();
			$this->session->set_flashdata('error', $error);
			redirect('post_skripsi');
		} else {
			$data_naskah = $this->upload->data();
			$file_name_naskah = $data_naskah['file_name'];
		}

		// Konfigurasi upload file program
		$config_program['upload_path'] = './file/skripsi/program';
		$config_program['allowed_types'] = 'rar|zip';
		$config_program['max_size'] = 0; // Tidak ada batasan ukuran

		$this->upload->initialize($config_program);

		if (!$this->upload->do_upload('file_program')) {
			$error = $this->upload->display_errors();
			$this->session->set_flashdata('error', $error);
			redirect('post_skripsi');
		} else {
			$data_program = $this->upload->data();
			$file_name_program = $data_program['file_name'];
		}

		$upload_data = array(
			'title_id' => $this->input->post('title_id'),
			'file_naskah' => $file_name_naskah,
			'file_program' => $file_name_program,
			'tanggal_upload' => date('Y-m-d H:i:s')
		);

		$this->Skppasca_model->insert($upload_data);

		// Redirect atau tampilkan pesan sukses
		$this->session->set_flashdata('success', 'File berhasil diupload.');
		redirect('post_skripsi');
	}


	public function dosen()
	{
		$pasca = $this->Skppasca_model->get_all();
		$data = [
			'title' => "Pasca Ujian Skripsi",
			'content' => 'post/skripsi/dosen/dosen',
			'pasca' => $pasca
		];
		$this->load->view('template/overlay/dosen', $data);
	}

	public function koordinator()
	{
		$pasca = $this->Skppasca_model->get_all();
		$data = [
			'title' => "Pasca Ujian Skripsi",
			'content' => 'post/skripsi/koordinator/koordinator',
			'pasca' => $pasca
		];
		$this->load->view('template/overlay/koordinator', $data);
	}

	public function admin()
	{
		$pasca = $this->Skppasca_model->get_all();
		$data = [
			'title' => "Pasca Ujian Skripsi",
			'content' => 'post/skripsi/admin/admin',
			'pasca' => $pasca
		];
		$this->load->view('template/overlay/admin', $data);
	}
}
