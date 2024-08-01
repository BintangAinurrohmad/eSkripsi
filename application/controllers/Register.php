<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->load->view('register');
    }

    public function register_user()
    {
        $this->form_validation->set_rules('npm', 'NPM', 'required|is_unique[users.npm]');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('angkatan', 'Angkatan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('register');
        } else {
            $data = array(
                'npm' => $this->input->post('npm'),
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'group_id' => 1,
				'angkatan' => $this->input->post('angkatan'),
            );
            $user_id = $this->User_model->register_user($data);
            if ($user_id) {
                $this->session->set_flashdata('success', 'Berhasil mendaftar! Silakan login.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Gagal mendaftar. Silakan coba lagi.');
                redirect('register');
            }
        }
    }
}
