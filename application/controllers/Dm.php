<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dm extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Ra_model');
		$this->load->model('Room_model');
		$this->load->model('Title_model');
	}

	public function index()
	{
		if (!$this->session->userdata('is_login')) {
			redirect('login');
		} else {
			if ($this->session->userdata('group_id') == 1) {
				redirect('dashboard');
			} else if ($this->session->userdata('group_id') == 2) {
				redirect('dashboard');
			} else if ($this->session->userdata('group_id') == 3) {
				redirect('dashboard');
			} else if ($this->session->userdata('group_id') == 4) {
				$this->admin();
			} else {
				redirect('login');
			}
		}
	}

	public function skripsi()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$skripsi = $this->Title_model->getSkripsi();
		$data = [
			'title' => "Data Skripsi",
			'content' => 'dm/skripsi/skripsi',
			'skripsi' => $skripsi,
		];
		$this->load->view('template/overlay/admin', $data);
	}

	public function add_skripsi()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$research_area = $this->Title_model->getResearchArea();
		$dosen = $this->Title_model->getDosen();
		$dosen2 = $this->Title_model->getDosen();
		$data = [
			'title' => "Tambah Data Skripsi",
			'content' => 'dm/skripsi/skripsi2',
			'research_area' => $research_area,
			'dosen' => $dosen,
			'dosen2' => $dosen2
		];
		$this->load->view('template/overlay/admin', $data);
	}

	public function insert_skripsi()
	{
		$this->form_validation->set_rules('nama_mahasiswa', 'Nama Mahasiswa', 'required');
		$this->form_validation->set_rules('npm', 'NPM', 'required');
		$this->form_validation->set_rules('judul', 'Judul', 'required');
		$this->form_validation->set_rules('bidang_id', 'Bidang', 'required');
		$this->form_validation->set_rules('dospem_1_id', 'Dosen Pembimbing 1', 'required');
		$this->form_validation->set_rules('dospem_2_id', 'Dosen Pembimbing 2', 'required');

		// If validation fails
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi.');
			redirect('dm/add_skripsi');
		} else {
			// If validation succeeds, save data to database
			$data['judul'] = $this->input->post('judul');
			$data['nama_mahasiswa'] = $this->input->post('nama_mahasiswa');
			$data['npm'] = $this->input->post('npm');
			$data['bidang_id'] = $this->input->post('bidang_id');
			$data['dospem_1_id'] = $this->input->post('dospem_1_id');
			$data['status_dospem_1'] = 'Diterima';
			$data['dospem_2_id'] = $this->input->post('dospem_2_id');
			$data['status_dospem_2'] = 'Diterima';
			$data['status'] = 'Diterima';

			if ($data['bidang_id'] == 'Pilih Bidang' || $data['dospem_1_id'] == 'Pilih Dosen' || $data['dospem_2_id'] == 'Pilih Dosen') {
				$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi.');
				redirect('dm/add_skripsi');
			} else {
				$this->Title_model->addSkripsi($data);

				$this->session->set_flashdata('success', 'Berhasil menambahkan data skripsi.');
				redirect('dm/skripsi');
			}
		}
	}

	public function admin()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$mahasiswa = $this->User_model->getMahasiswa();
		$dosen = $this->User_model->getDosen();
		$koordinator = $this->User_model->getKoordinator();
		$admin = $this->User_model->getAdmin();
		$data = [
			'title' => "Data Master",
			'content' => 'dm/pengguna/list',
			'mahasiswa' => $mahasiswa,
			'dosen' => $dosen,
			'koordinator' => $koordinator,
			'admin' => $admin
		];
		$this->load->view('template/overlay/admin', $data);
	}

	public function reset_password($id)
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$user = $this->User_model->get_user_by_id($id);
		$data['password'] = password_hash($user->npm, PASSWORD_DEFAULT);
		$this->User_model->editUser($id, $data);
		$this->session->set_flashdata('success', 'Berhasil mengatur ulang kata sandi.');
		redirect('dm');
	}

	public function add()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$role = $this->User_model->getRole();
		$data = [
			'title' => "Tambah Pengguna",
			'content' => 'dm/pengguna/add',
			'role' => $role
		];
		$this->load->view('template/overlay/admin', $data);
	}

	public function add_user()
	{
		$this->form_validation->set_rules('npm', 'NPM', 'required|is_unique[users.npm]');
		$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('role', 'role', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi dan NPM/NIDN/Email tidak boleh sama');
			redirect('dm/add');
		} else {
			$data = array(
				'npm' => $this->input->post('npm'),
				'nama' => $this->input->post('nama'),
				'email' => $this->input->post('email'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'group_id' => $this->input->post('role'),
				'angkatan' => $this->input->post('angkatan')
			);

			if ($data['group_id'] == '-- Pilih Jenis Pengguna --') {
				$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi.');
				redirect('dm/add');
			}

			$user_id = $this->User_model->register_user($data);
			if ($user_id) {
				$this->session->set_flashdata('success', 'Berhasil menambahkan pengguna.');
				redirect('dm');
			} else {
				$this->session->set_flashdata('error', 'Gagal menambahkan pengguna. Silakan coba lagi.');
				redirect('dm');
			}
		}
	}

	public function delete_user($id)
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$this->load->model('User_model');

		// Get the user data
		$user = $this->User_model->get_user_by_id($id);

		if (!$user) {
			// User not found, show error message
			$this->session->set_flashdata('error', 'User not found');
			redirect('user/list');
		}

		// Delete the user, ignoring foreign key constraints
		$this->db->trans_start();
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0');
		$this->User_model->delete($id);
		$this->db->query('SET FOREIGN_KEY_CHECKS = 1');
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			// Error deleting user, show error message
			$this->session->set_flashdata('error', 'Gagal Menghapus Pengguna');
			redirect('dm');
		} else {
			// User deleted successfully, show success message
			$this->session->set_flashdata('success', 'Pengguna Berhasil Dihapus');
			redirect('dm');
		}
	}

	public function edit_user($id)
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$role = $this->User_model->getRole();
		$user = $this->User_model->get_user_by_id($id);
		$data = [
			'title' => "Sunting Pengguna",
			'content' => 'dm/pengguna/edit',
			'role' => $role,
			'user' => $user
		];
		$this->load->view('template/overlay/admin', $data);
	}

	public function set_user()
	{
		$id = $this->input->post('id');

		$this->form_validation->set_rules('npm', 'NPM', 'required');
		$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('role', 'role', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Seluruh kolom wajib diisi dan NPM/NIDN/Email tidak boleh sama dengan user lain');
			redirect('dm/edit_user/' . $id);
		} else {
			$data = array(
				'npm' => $this->input->post('npm'),
				'nama' => $this->input->post('nama'),
				'email' => $this->input->post('email'),
				'group_id' => $this->input->post('role'),
				'angkatan' => $this->input->post('angkatan')
			);

			$this->User_model->editUser($id, $data);
			$this->session->set_flashdata('success', 'Berhasil menyunting pengguna.');
			redirect('dm');
		}
	}

	public function research_area()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$ra = $this->Ra_model->get();
		$data = [
			'title' => "Data Bidang Penelitian",
			'content' => 'dm/research_area',
			'ra' => $ra
		];
		$this->load->view('template/overlay/admin', $data);
	}

	public function add_research_area()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$this->form_validation->set_rules('ra', 'Nama Bidang Benelitian', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Harap Masukkan Nama Bidang Penelitian');
			redirect('dm/research_area');
		} else {
			$data = array(
				'nama' => $this->input->post('ra'),
			);
			$this->Ra_model->create($data);

			$this->session->set_flashdata('success', 'Berhasil Menambahkan Bidang Penelitian');
			redirect('dm/research_area');
		}
	}

	public function delete_research_area($id)
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$this->Ra_model->delete($id);
		$this->session->set_flashdata('success', 'Berhasil Menghapus Bidang Penelitian');
		redirect('dm/research_area');
	}

	public function room()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$rooms = $this->Room_model->get();
		$data = [
			'title' => "Data Ruang Ujian",
			'content' => 'dm/room',
			'rooms' => $rooms
		];
		$this->load->view('template/overlay/admin', $data);
	}

	public function add_room()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$this->form_validation->set_rules('ra', 'Nama Ruangan', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Harap Masukkan Nama Bidang Penelitian');
			redirect('dm/room');
		} else {
			$data = array(
				'nama' => $this->input->post('ra'),
			);
			$this->Room_model->create($data);

			$this->session->set_flashdata('success', 'Berhasil Menambahkan Bidang Penelitian');
			redirect('dm/room');
		}
	}

	public function delete_room($id)
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$this->Room_model->delete($id);
		$this->session->set_flashdata('success', 'Berhasil Menghapus Bidang Penelitian');
		redirect('dm/room');
	}
}
