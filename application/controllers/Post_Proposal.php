<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_Proposal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Propasca_model');
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
			} else if ($this->session->userdata('group_id') == 3){
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
			'title' => "Naskah Proposal",
			'content' => 'post/proposal/view_naskah',
			'file_naskah' => $file_naskah
		];
		$this->load->view($overlay, $data);
	}

	public function mahasiswa()
	{
		$judul = $this->Propasca_model->get_title($this->session->userdata('user_id'));

		if ($judul) {
			$content = 'post/proposal/mahasiswa/mahasiswa';
		} else {
			$content = 'post/proposal/mahasiswa/mahasiswa2';
		}

		$data = [
			'title' => "Pasca Ujian Proposal",
			'content' => $content, 
			'judul' => $judul,
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function upload() {
        $config['upload_path']          = './file/proposal/naskah_final'; 
        $config['allowed_types']        = 'pdf'; 
        $config['max_size']             = 10240; 

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('proposal_final')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
			redirect('post_proposal');
        } else {
            $data = $this->upload->data();
            $file_name = $data['file_name'];

            $upload_data = array(
                'title_id' => $this->input->post('title_id'),
                'file_naskah' => $file_name,
                'tanggal_upload' => date('Y-m-d H:i:s')
            );

            $this->Propasca_model->insert($upload_data);

            // Redirect atau tampilkan pesan sukses
            redirect('post_proposal');
        }
	}

    public function dosen()
	{
		$pasca = $this->Propasca_model->get_all();
		$data = [
			'title' => "Pasca Ujian Proposal",
			'content' => 'post/proposal/dosen/dosen',
			'pasca' => $pasca
		];
		$this->load->view('template/overlay/dosen', $data);
	}

    public function koordinator()
	{
		$pasca = $this->Propasca_model->get_all();
		$data = [
			'title' => "Pasca Ujian Proposal",
			'content' => 'post/proposal/koordinator/koordinator', 
			'pasca' => $pasca
		];
		$this->load->view('template/overlay/koordinator', $data);
	}

    public function admin()
	{
		$pasca = $this->Propasca_model->get_all();
		$data = [
			'title' => "Pasca Ujian Proposal",
			'content' => 'post/proposal/admin/admin',
			'pasca' => $pasca
		];
		$this->load->view('template/overlay/admin', $data);
	}
}
