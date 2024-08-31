<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Announcement_model');
		$this->load->model('Dashboard_model');
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
		$this->load->model('Dashboard_model');
		$this->load->model('Title_model'); // Load the Title_model

		$user_id = $this->session->userdata('user_id');


		if ($user_id) {
			$lastTitle = $this->Title_model->getMyLastAccTitle($user_id);
			$user_name = $this->Dashboard_model->getLoggedInUserName(); // Get the user name

			$data = [
				'my_title' => $lastTitle,
				'title' => "Selamat Datang, $user_name",
				'content' => 'dashboard/mahasiswa',
				'user_name' => $user_name,
				'approved_count' => $this->Dashboard_model->getMhsToday($user_id),
				'data_proposal' => $this->Dashboard_model->get_proposal_data_by_user_id($user_id),
				'guidance_count' => $this->Dashboard_model->get_guidance_count($user_id),
				'last_guidance_date' => $this->Dashboard_model->get_last_guidance_date($user_id),
				'pengumuman' => $this->Announcement_model->get()
			];

			$this->load->view('template/overlay/mahasiswa', $data);
		} else {
			$this->session->set_flashdata('error', 'User ID not found in session');
			redirect('login', 'refresh');
		}
	}

	public function dosen()
	{
		$dosen_id = $this->session->userdata('user_id'); // Assuming the dosen ID is retrieved from the session
		$this->load->model('Dashboard_model');

		$data['pengumuman'] = $this->Announcement_model->get();

		$data['judul'] = $this->Dashboard_model->getBelumDisetujuiJudul();
		$data['dibimbing'] = $this->Dashboard_model->getMahasiswaDibimbing();
		$data['belumBimbingan'] = $this->Dashboard_model->getBelumBimbingan();
		$data['belumSeminar'] = $this->Dashboard_model->getBelumSeminar();
		$data['belumSkripsi'] = $this->Dashboard_model->getBelumSkripsi();
		//$data['dosen_mahasiswa'] = $this->Dashboard_model->get_dosen_mahasiswa();

		// Assuming getLoggedInUserName returns a string
		$user_name = $this->Dashboard_model->getLoggedInUserName();

		$data['jumlah_belum_disetujui'] = $this->Dashboard_model->count_pending_approval($dosen_id);
		$data['jumlahskp_belum_disetujui'] = $this->Dashboard_model->count_pending_approvalskp($dosen_id);

		$total_count = $this->Dashboard_model->countDsn($dosen_id);
		$data['total_count'] = $total_count;

		// Adding a new element to the $data array
		$data['title'] = "Selamat Datang, $user_name";
		$data['content'] = 'dashboard/dosen';

		$this->load->view('template/overlay/dosen', $data);
	}



	public function koordinator()
	{
		$dosen_id = $this->session->userdata('user_id'); // Asumsi ID dosen diambil dari sesi

		$this->load->model('title_model');
		$this->load->model('Dashboard_model');

		$data['pengumuman'] = $this->Announcement_model->get();

		$data['judul'] = $this->Dashboard_model->getBelumDisetujuiJudul();
		$data['dibimbing'] = $this->Dashboard_model->getMahasiswaDibimbing();
		$data['belumBimbingan'] = $this->Dashboard_model->getBelumBimbingan();
		$data['belumSeminar'] = $this->Dashboard_model->getBelumSeminar();
		$data['belumSkripsi'] = $this->Dashboard_model->getBelumSkripsi();

		// Menggunakan fungsi yang benar untuk mendapatkan data dosen dan mahasiswa bimbingan
		$data['dosen_mahasiswa'] = $this->Dashboard_model->get_dosen_mahasiswa_bimbingan();

		$data['user_name'] = $this->Dashboard_model->getLoggedInUserName();

		$jumlah_jadwal = $this->Dashboard_model->get_jumlah_jadwal();
		$jumlah_jadwal_today = $this->Dashboard_model->get_jumlah_jadwal_today();

		$jumlah_jadwal_skp = $this->Dashboard_model->get_jumlah_jadwal_skp();
		$jumlah_jadwal_today_skp = $this->Dashboard_model->get_jumlah_jadwal_today_skp();

		$data['jumlah_jadwal'] = $jumlah_jadwal;
		$data['jumlah_jadwal_today'] = $jumlah_jadwal_today;

		$data['jumlah_jadwal_skp'] = $jumlah_jadwal_skp;
		$data['jumlah_jadwal_today_skp'] = $jumlah_jadwal_today_skp;

		$data['jumlah_belum_disetujui'] = $this->Dashboard_model->count_pending_approval($dosen_id);

		$data['total_judul_baru'] = $this->Dashboard_model->count_total_judul_baru();

		$total_count = $this->Dashboard_model->countKdr($dosen_id);
		$data['total_count'] = $total_count;

		$data['jumlahskp_belum_disetujui'] = $this->Dashboard_model->count_pending_approvalskp($dosen_id);

		$user_name = $this->Dashboard_model->getLoggedInUserName();

		// Menambahkan elemen baru ke array $data
		$data['title'] = "Selamat Datang, $user_name";
		$data['content'] = 'dashboard/koordinator';

		$this->load->view('template/overlay/koordinator', $data);
	}



	public function admin()
	{
		$dosen_id = $this->session->userdata('user_id'); // Asumsi ID dosen diambil dari sesi

		$this->load->model('title_model');
		$this->load->model('Dashboard_model');

		$data['pengumuman'] = $this->Announcement_model->get();
		
		$data['judul'] = $this->Dashboard_model->getBelumDisetujuiJudul();
		$data['dibimbing'] = $this->Dashboard_model->getMahasiswaDibimbing();
		$data['belumBimbingan'] = $this->Dashboard_model->getBelumBimbingan();
		$data['belumSeminar'] = $this->Dashboard_model->getBelumSeminar();
		$data['belumSkripsi'] = $this->Dashboard_model->getBelumSkripsi();
		
		$data['user_name'] = $this->Dashboard_model->getLoggedInUserName();

		$jumlah_jadwal = $this->Dashboard_model->get_jumlah_jadwal();
		$jumlah_jadwal_today = $this->Dashboard_model->get_jumlah_jadwal_today();

		$data['jumlah_jadwal'] = $jumlah_jadwal;
		$data['jumlah_jadwal_today'] = $jumlah_jadwal_today;


		$data['jumlah_belum_disetujui'] = $this->Dashboard_model->count_pending_approval($dosen_id);

		$data['total_judul'] = $this->Dashboard_model->count_total_judul();

		$count = $this->Dashboard_model->countDsn($dosen_id);
		$data['count'] = $count;

		$data['jumlahskp_belum_disetujui'] = $this->Dashboard_model->count_pending_approvalskp($dosen_id);

		$data['dosen_mahasiswa'] = $this->Dashboard_model->get_dosen_mahasiswa_bimbingan();

		$data['title'] = "Selamat Datang di Dashboard";
		$data['content'] = 'dashboard/admin';

		$this->load->view('template/overlay/admin', $data);
	}
}
