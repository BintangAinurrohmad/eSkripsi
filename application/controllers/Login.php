<?php
defined('BASEPATH') or exit('No directscript access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('is_login')) {
            redirect('dashboard');
        } else {
            $this->load->view('login');
        }
    }

    public function login_user()
    {
        $this->form_validation->set_rules('npm_or_email', 'NPM/Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            $npm_or_email = $this->input->post('npm_or_email');
            $password = $this->input->post('password');
            $user = $this->User_model->get_user_by_npm_or_email($npm_or_email);
            if ($user) {
                if ($this->User_model->check_password($user->id, $password)) {
                    $this->session->set_userdata('user_id', $user->id);
                    $this->session->set_userdata('group_id', $user->group_id);
                    $this->session->set_userdata('name', $user->nama);
                    $this->session->set_userdata('is_login', TRUE);
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Password salah.');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('error', 'NPM/Email tidak terdaftar.');
                redirect('login');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}