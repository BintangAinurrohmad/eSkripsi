<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	public function index()
	{
	}

	public function my_profile()
	{
		$myProfile = $this->User_model->get_profile($this->session->userdata('user_id'));
		$data = [
			'title' => "Profile Saya",
			'content' => 'myprofile',
			'myProfile' => $myProfile
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function edit_my_profile()
	{
		// $this->form_validation->set_rules('npm', 'NPM', 'required|is_unique[users.npm]');
		// $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
		// $this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');

		// if ($this->form_validation->run() == FALSE) {
		// $this->session->set_flashdata('error', 'Nama, NPM, dan Email Tidak Boleh Dikosongi.');
		// redirect('profile/my_profile');
		// } else {
		$data = array(
			'npm' => $this->input->post('npm'),
			'nama' => $this->input->post('nama'),
			'email' => $this->input->post('email'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'tempat_lahir' => $this->input->post('tempat_lahir'),
			'tgl_lahir' => $this->input->post('tgl_lahir'),
			'alamat' => $this->input->post('alamat'),
			'telepon' => $this->input->post('telepon'),
			'angkatan' => $this->input->post('angkatan'),
		);
		$this->User_model->update_profile($this->session->userdata('user_id'), $data);
		$this->session->set_flashdata('success', 'Berhasil Memperbarui Profil.');
		redirect('profile/my_profile');
		// }
	}

	public function edit_my_password()
	{
		$id = $this->session->userdata('user_id');

		$this->form_validation->set_rules('old_password', 'Old Password', 'required');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('profile/my_profile');
		} else {
			$old_password = $this->input->post('old_password');
			$new_password = $this->input->post('new_password');

			$user = $this->User_model->get_user_by_id($id);
			if (password_verify($old_password, $user->password)) {
				$this->User_model->update_password($id, $new_password);
				$this->session->set_flashdata('success', 'Kata Sandi Berhasil Diperbarui');
				redirect('profile/my_profile');
			} else {
				$this->session->set_flashdata('error', 'Gagal Memperbarui Kata Sandi');
				redirect('profile/my_profile');
			}
		}
	}
}
