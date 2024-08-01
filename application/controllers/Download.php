<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Download extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Download_model');
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
		$downloads = $this->Download_model->get();
		$data = [
			'title' => "Unduhan",
			'content' => 'dm/download/main',
			'downloads' => $downloads
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function dosen()
	{
		$downloads = $this->Download_model->get();
		$data = [
			'title' => "Unduhan",
			'content' => 'dm/download/main',
			'downloads' => $downloads
		];
		$this->load->view('template/overlay/dosen', $data);
	}

	public function koordinator()
	{
		$downloads = $this->Download_model->get();
		$data = [
			'title' => "Unduhan",
			'content' => 'dm/download/main',
			'downloads' => $downloads
		];
		$this->load->view('template/overlay/koordinator', $data);
	}

	public function admin()
	{
		$downloads = $this->Download_model->get();
		$data = [
			'title' => "Unduhan",
			'content' => 'dm/download/admin',
			'downloads' => $downloads
		];
		$this->load->view('template/overlay/admin', $data);
	}

	public function upload_file()
	{
		$this->load->library('upload');

		$config['upload_path'] = './file/downloads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|docx|xlsx|pptx';
		$config['max_size'] = 1024 * 5; // 5MB

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('download/');
		} else {
			$data = array('upload_data' => $this->upload->data());
			$file_name = $data['upload_data']['file_name'];
			$name = $this->input->post('name');

			$download_data = array(
				'name' => $name,
				'file_name' => $file_name,
				'uploader' => $this->session->userdata('user_id'),
			);

			$this->Download_model->insert_download($download_data);

			$this->session->set_flashdata('success', 'Berkas Unduhan Berhasil Diunggah');
			redirect('download');
		}
	}

	public function delete_file($id)
	{
		$this->load->helper('file');

		$download = $this->Download_model->get_download_by_id($id);
		if ($download) {
			$file_path = './file/downloads/' . $download->file_name;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
			$this->Download_model->delete_download($id);
			$this->session->set_flashdata('success', 'Berkas Berhasil Dihapus!');
			redirect('download');
		} else {
			$this->session->set_flashdata('error', 'Berkas Tidak Ditemukan!');
			redirect('download');
		}
	}
}
