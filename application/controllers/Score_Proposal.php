<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Score_Proposal extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Proscore_model');
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
				$this->dosen();
			} else if ($this->session->userdata('group_id') == 4) {
				$this->admin();
			} else {
				redirect('login');
			}
		}
	}

	public function mahasiswa()
	{
		if ($this->session->userdata('group_id') != 1) {
			redirect('error404');
		}

		$ujian = $this->Proscore_model->getNilai($this->session->userdata('user_id'));
		$data = [
			'title' => "Nilai Ujian Proposal",
			'content' => 'score/proposal/mahasiswa/mahasiswa',
			'ujian' => $ujian
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function download_nilai($id)
	{

		require_once APPPATH . 'third_party/PhpWord/PhpWordAutoloader.php';

		$data = $this->Proscore_model->getNilaiData($id);

		setlocale(LC_TIME, 'id_ID.UTF-8');
		$tanggal = $data->tanggal;
		$hari = strftime('%A', strtotime($tanggal));
		$tgl = date('d', strtotime($tanggal));
		$bulan = strftime('%B', strtotime($tanggal));
		$tahun = date('Y', strtotime($tanggal));
		$now = strftime("%d %B %Y", strtotime($tanggal));

		$dosuji1 = $this->db->where('id', $data->dosuji_1_id)->get('users')->row();
		$dosuji2 = $this->db->where('id', $data->dosuji_2_id)->get('users')->row();
		$dospem1 = $this->db->where('id', $data->dospem_1_id)->get('users')->row();
		$dospem2 = $this->db->where('id', $data->dospem_2_id)->get('users')->row();
		$mahasiswa = $this->db->where('id', $data->mahasiswa)->get('users')->row();
		$room = $this->db->where('id', $data->room_id)->get('rooms')->row();

		$nilaiDospem1 = $this->Proscore_model->getNilaiDospem1($id, $dospem1->id);
		$nilaiDospem2 = $this->Proscore_model->getNilaiDospem2($id, $dospem2->id);
		$nilaiDosuji1 = $this->Proscore_model->getNilaiDosuji1($id, $dosuji1->id);
		$nilaiDosuji2 = $this->Proscore_model->getNilaiDosuji2($id, $dosuji2->id);

		$rata_bimbingan = ($nilaiDospem1->rata_c + $nilaiDospem2->rata_c) / 2;

		$rata_naskah_dospem = ($nilaiDospem1->rata_a + $nilaiDospem2->rata_a) / 2;
		$rata_pelaksanaan_dospem = ($nilaiDospem1->rata_b + $nilaiDospem2->rata_b) / 2;
		$rata_naskah_dosuji = ($nilaiDosuji1->rata_a + $nilaiDosuji2->rata_a) / 2;
		$rata_pelaksanaan_dosuji = ($nilaiDosuji1->rata_b + $nilaiDosuji2->rata_b) / 2;

		$rata_naskah = ($rata_naskah_dospem + $rata_naskah_dosuji) / 2;
		$rata_pelaksanaan = ($rata_pelaksanaan_dospem + $rata_pelaksanaan_dosuji) / 2;

		$bs_rata_bimbingan = $rata_bimbingan * 20;
		$bs_rata_naskah = $rata_naskah * 30;
		$bs_rata_pelaksanaan = $rata_pelaksanaan * 50;

		$skor_total = $bs_rata_bimbingan + $bs_rata_naskah + $bs_rata_pelaksanaan;
		$skor_akhir = $skor_total / 100;

		if ($skor_akhir >= 81 && $skor_akhir <= 100) {
			$nilai_akhir = 'A';
		} else if ($skor_akhir >= 76 && $skor_akhir < 81) {
			$nilai_akhir = 'AB';
		} else if ($skor_akhir >= 71 && $skor_akhir < 76) {
			$nilai_akhir = 'B';
		} else if ($skor_akhir >= 66 && $skor_akhir < 71) {
			$nilai_akhir = 'BC';
		} else if ($skor_akhir >= 56 && $skor_akhir < 66) {
			$nilai_akhir = 'C';
		} else if ($skor_akhir >= 46 && $skor_akhir < 56) {
			$nilai_akhir = 'D';
		} else {
			$nilai_akhir = 'E';
		}

		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("template_nilai_proposal.docx");

		$templateProcessor->setValues([
			'dosuji1' => $dosuji1->nama,
			'dosuji1_nidn' => $dosuji1->npm,
			'dosuji2' => $dosuji2->nama,
			'dosuji2_nidn' => $dosuji2->npm,
			'dospem1' => $dospem1->nama,
			'dospem1_nidn' => $dospem1->npm,
			'dospem2' => $dospem2->nama,
			'dospem2_nidn' => $dospem2->npm,
			'judul' => $data->judul,
			'mahasiswa' => $mahasiswa->nama,
			'angkatan' => $mahasiswa->angkatan,
			'npm' => $mahasiswa->npm,
			'hari' => $hari,
			'tgl' => $tgl,
			'bulan' => $bulan,
			'tahun' => $tahun,
			'now' => $now,
			'room' => $room->nama,
			'bimbingan_ketekunan_1' => $nilaiDospem1->bimbingan_ketekunan,
			'bimbingan_adab_1' => $nilaiDospem1->bimbingan_adab,
			'bimbingan_kemandirian_1' => $nilaiDospem1->bimbingan_kemandirian,
			'total_c_1' => $nilaiDospem1->total_c,
			'rata_c_1' => $nilaiDospem1->rata_c,
			'naskah_penulisan_1' => $nilaiDospem1->naskah_penulisan,
			'naskah_pemikiran_1' => $nilaiDospem1->naskah_pemikiran,
			'naskah_kajian_1' => $nilaiDospem1->naskah_kajian,
			'naskah_metode_1' => $nilaiDospem1->naskah_metode,
			'naskah_hasil_1' => $nilaiDospem1->naskah_hasil,
			'naskah_kesimpulan_1' => $nilaiDospem1->naskah_kesimpulan,
			'naskah_kepustakaan_1' => $nilaiDospem1->naskah_kepustakaan,
			'bs_naskah_penulisan_1' => $nilaiDospem1->bs_naskah_penulisan,
			'bs_naskah_pemikiran_1' => $nilaiDospem1->bs_naskah_pemikiran,
			'bs_naskah_kajian_1' => $nilaiDospem1->bs_naskah_kajian,
			'bs_naskah_metode_1' => $nilaiDospem1->bs_naskah_metode,
			'bs_naskah_hasil_1' => $nilaiDospem1->bs_naskah_hasil,
			'bs_naskah_kesimpulan_1' => $nilaiDospem1->bs_naskah_kesimpulan,
			'bs_naskah_kepustakaan_1' => $nilaiDospem1->bs_naskah_kepustakaan,
			'total_a_1' => $nilaiDospem1->total_a,
			'rata_a_1' => $nilaiDospem1->rata_a,
			'pelaksanaan_presentasi_1' => $nilaiDospem1->pelaksanaan_presentasi,
			'pelaksanaan_penguasaan_1' => $nilaiDospem1->pelaksanaan_penguasaan,
			'pelaksanaan_argumentasi_1' => $nilaiDospem1->pelaksanaan_argumentasi,
			'bs_pelaksanaan_presentasi_1' => $nilaiDospem1->bs_pelaksanaan_presentasi,
			'bs_pelaksanaan_penguasaan_1' => $nilaiDospem1->bs_pelaksanaan_penguasaan,
			'bs_pelaksanaan_argumentasi_1' => $nilaiDospem1->bs_pelaksanaan_argumentasi,
			'total_b_1' => $nilaiDospem1->total_b,
			'rata_b_1' => $nilaiDospem1->rata_b,
			'bimbingan_ketekunan_2' => $nilaiDospem2->bimbingan_ketekunan,
			'bimbingan_adab_2' => $nilaiDospem2->bimbingan_adab,
			'bimbingan_kemandirian_2' => $nilaiDospem2->bimbingan_kemandirian,
			'total_c_2' => $nilaiDospem2->total_c,
			'rata_c_2' => $nilaiDospem2->rata_c,
			'naskah_penulisan_2' => $nilaiDospem2->naskah_penulisan,
			'naskah_pemikiran_2' => $nilaiDospem2->naskah_pemikiran,
			'naskah_kajian_2' => $nilaiDospem2->naskah_kajian,
			'naskah_metode_2' => $nilaiDospem2->naskah_metode,
			'naskah_hasil_2' => $nilaiDospem2->naskah_hasil,
			'naskah_kesimpulan_2' => $nilaiDospem2->naskah_kesimpulan,
			'naskah_kepustakaan_2' => $nilaiDospem2->naskah_kepustakaan,
			'bs_naskah_penulisan_2' => $nilaiDospem2->bs_naskah_penulisan,
			'bs_naskah_pemikiran_2' => $nilaiDospem2->bs_naskah_pemikiran,
			'bs_naskah_kajian_2' => $nilaiDospem2->bs_naskah_kajian,
			'bs_naskah_metode_2' => $nilaiDospem2->bs_naskah_metode,
			'bs_naskah_hasil_2' => $nilaiDospem2->bs_naskah_hasil,
			'bs_naskah_kesimpulan_2' => $nilaiDospem2->bs_naskah_kesimpulan,
			'bs_naskah_kepustakaan_2' => $nilaiDospem2->bs_naskah_kepustakaan,
			'total_a_2' => $nilaiDospem2->total_a,
			'rata_a_2' => $nilaiDospem2->rata_a,
			'pelaksanaan_presentasi_2' => $nilaiDospem2->pelaksanaan_presentasi,
			'pelaksanaan_penguasaan_2' => $nilaiDospem2->pelaksanaan_penguasaan,
			'pelaksanaan_argumentasi_2' => $nilaiDospem2->pelaksanaan_argumentasi,
			'bs_pelaksanaan_presentasi_2' => $nilaiDospem2->bs_pelaksanaan_presentasi,
			'bs_pelaksanaan_penguasaan_2' => $nilaiDospem2->bs_pelaksanaan_penguasaan,
			'bs_pelaksanaan_argumentasi_2' => $nilaiDospem2->bs_pelaksanaan_argumentasi,
			'total_b_2' => $nilaiDospem2->total_b,
			'rata_b_2' => $nilaiDospem2->rata_b,
			'naskah_penulisan_3' => $nilaiDosuji1->naskah_penulisan,
			'naskah_pemikiran_3' => $nilaiDosuji1->naskah_pemikiran,
			'naskah_kajian_3' => $nilaiDosuji1->naskah_kajian,
			'naskah_metode_3' => $nilaiDosuji1->naskah_metode,
			'naskah_hasil_3' => $nilaiDosuji1->naskah_hasil,
			'naskah_kesimpulan_3' => $nilaiDosuji1->naskah_kesimpulan,
			'naskah_kepustakaan_3' => $nilaiDosuji1->naskah_kepustakaan,
			'bs_naskah_penulisan_3' => $nilaiDosuji1->bs_naskah_penulisan,
			'bs_naskah_pemikiran_3' => $nilaiDosuji1->bs_naskah_pemikiran,
			'bs_naskah_kajian_3' => $nilaiDosuji1->bs_naskah_kajian,
			'bs_naskah_metode_3' => $nilaiDosuji1->bs_naskah_metode,
			'bs_naskah_hasil_3' => $nilaiDosuji1->bs_naskah_hasil,
			'bs_naskah_kesimpulan_3' => $nilaiDosuji1->bs_naskah_kesimpulan,
			'bs_naskah_kepustakaan_3' => $nilaiDosuji1->bs_naskah_kepustakaan,
			'total_a_3' => $nilaiDosuji1->total_a,
			'rata_a_3' => $nilaiDosuji1->rata_a,
			'pelaksanaan_presentasi_3' => $nilaiDosuji1->pelaksanaan_presentasi,
			'pelaksanaan_penguasaan_3' => $nilaiDosuji1->pelaksanaan_penguasaan,
			'pelaksanaan_argumentasi_3' => $nilaiDosuji1->pelaksanaan_argumentasi,
			'bs_pelaksanaan_presentasi_3' => $nilaiDosuji1->bs_pelaksanaan_presentasi,
			'bs_pelaksanaan_penguasaan_3' => $nilaiDosuji1->bs_pelaksanaan_penguasaan,
			'bs_pelaksanaan_argumentasi_3' => $nilaiDosuji1->bs_pelaksanaan_argumentasi,
			'total_b_3' => $nilaiDosuji1->total_b,
			'rata_b_3' => $nilaiDosuji1->rata_b,
			'naskah_penulisan_4' => $nilaiDosuji2->naskah_penulisan,
			'naskah_pemikiran_4' => $nilaiDosuji2->naskah_pemikiran,
			'naskah_kajian_4' => $nilaiDosuji2->naskah_kajian,
			'naskah_metode_4' => $nilaiDosuji2->naskah_metode,
			'naskah_hasil_4' => $nilaiDosuji2->naskah_hasil,
			'naskah_kesimpulan_4' => $nilaiDosuji2->naskah_kesimpulan,
			'naskah_kepustakaan_4' => $nilaiDosuji2->naskah_kepustakaan,
			'bs_naskah_penulisan_4' => $nilaiDosuji2->bs_naskah_penulisan,
			'bs_naskah_pemikiran_4' => $nilaiDosuji2->bs_naskah_pemikiran,
			'bs_naskah_kajian_4' => $nilaiDosuji2->bs_naskah_kajian,
			'bs_naskah_metode_4' => $nilaiDosuji2->bs_naskah_metode,
			'bs_naskah_hasil_4' => $nilaiDosuji2->bs_naskah_hasil,
			'bs_naskah_kesimpulan_4' => $nilaiDosuji2->bs_naskah_kesimpulan,
			'bs_naskah_kepustakaan_4' => $nilaiDosuji2->bs_naskah_kepustakaan,
			'total_a_4' => $nilaiDosuji2->total_a,
			'rata_a_4' => $nilaiDosuji2->rata_a,
			'pelaksanaan_presentasi_4' => $nilaiDosuji2->pelaksanaan_presentasi,
			'pelaksanaan_penguasaan_4' => $nilaiDosuji2->pelaksanaan_penguasaan,
			'pelaksanaan_argumentasi_4' => $nilaiDosuji2->pelaksanaan_argumentasi,
			'bs_pelaksanaan_presentasi_4' => $nilaiDosuji2->bs_pelaksanaan_presentasi,
			'bs_pelaksanaan_penguasaan_4' => $nilaiDosuji2->bs_pelaksanaan_penguasaan,
			'bs_pelaksanaan_argumentasi_4' => $nilaiDosuji2->bs_pelaksanaan_argumentasi,
			'total_b_4' => $nilaiDosuji2->total_b,
			'rata_b_4' => $nilaiDosuji2->rata_b,
			'rata_bimbingan_dospem' => $rata_bimbingan,
			'rata_naskah_dospem' => $rata_naskah_dospem,
			'rata_pelaksanaan_dospem' => $rata_pelaksanaan_dospem,
			'rata_naskah_dosuji' => $rata_naskah_dosuji,
			'rata_pelaksanaan_dosuji' => $rata_pelaksanaan_dosuji,
			'bs_rata_bimbingan' => $bs_rata_bimbingan,
			'bs_rata_naskah' => $bs_rata_naskah,
			'bs_rata_pelaksanaan' => $bs_rata_pelaksanaan,
			'skor_total' => $skor_total,
			'skor_akhir' => $skor_akhir,
			'nilai_akhir' => $nilai_akhir
		]);

		$tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
		$templateProcessor->saveAs($tempFile);

		// Download the file
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Disposition: attachment; filename="nilai_proposal.docx"');
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Expires: 0');
		header('Pragma: public');
		flush();
		readfile($tempFile);
		unlink($tempFile);
		exit;
	}

	public function view_nilai($id)
	{
		$data = $this->Proscore_model->getNilaiData($id);

		setlocale(LC_TIME, 'id_ID.UTF-8');
		$tanggal = $data->tanggal;
		$now = strftime("%d %B %Y", strtotime($tanggal));

		$dosuji1 = $this->db->where('id', $data->dosuji_1_id)->get('users')->row();
		$dosuji2 = $this->db->where('id', $data->dosuji_2_id)->get('users')->row();
		$dospem1 = $this->db->where('id', $data->dospem_1_id)->get('users')->row();
		$dospem2 = $this->db->where('id', $data->dospem_2_id)->get('users')->row();
		$mahasiswa = $this->db->where('id', $data->mahasiswa)->get('users')->row();
		$room = $this->db->where('id', $data->room_id)->get('rooms')->row();

		$nilaiDospem1 = $this->Proscore_model->getNilaiDospem1($id, $dospem1->id);
		$nilaiDospem2 = $this->Proscore_model->getNilaiDospem2($id, $dospem2->id);
		$nilaiDosuji1 = $this->Proscore_model->getNilaiDosuji1($id, $dosuji1->id);
		$nilaiDosuji2 = $this->Proscore_model->getNilaiDosuji2($id, $dosuji2->id);

		$rata_bimbingan = ($nilaiDospem1->rata_c + $nilaiDospem2->rata_c) / 2;

		$rata_naskah_dospem = ($nilaiDospem1->rata_a + $nilaiDospem2->rata_a) / 2;
		$rata_pelaksanaan_dospem = ($nilaiDospem1->rata_b + $nilaiDospem2->rata_b) / 2;
		$rata_naskah_dosuji = ($nilaiDosuji1->rata_a + $nilaiDosuji2->rata_a) / 2;
		$rata_pelaksanaan_dosuji = ($nilaiDosuji1->rata_b + $nilaiDosuji2->rata_b) / 2;

		$rata_naskah = ($rata_naskah_dospem + $rata_naskah_dosuji) / 2;
		$rata_pelaksanaan = ($rata_pelaksanaan_dospem + $rata_pelaksanaan_dosuji) / 2;

		$bs_rata_bimbingan = $rata_bimbingan * 20;
		$bs_rata_naskah = $rata_naskah * 30;
		$bs_rata_pelaksanaan = $rata_pelaksanaan * 50;

		$skor_total = $bs_rata_bimbingan + $bs_rata_naskah + $bs_rata_pelaksanaan;
		$skor_akhir = $skor_total / 100;

		if ($skor_akhir >= 81 && $skor_akhir <= 100) {
			$nilai_akhir = 'A';
		} else if ($skor_akhir >= 76 && $skor_akhir < 81) {
			$nilai_akhir = 'AB';
		} else if ($skor_akhir >= 71 && $skor_akhir < 76) {
			$nilai_akhir = 'B';
		} else if ($skor_akhir >= 66 && $skor_akhir < 71) {
			$nilai_akhir = 'BC';
		} else if ($skor_akhir >= 56 && $skor_akhir < 66) {
			$nilai_akhir = 'C';
		} else if ($skor_akhir >= 46 && $skor_akhir < 56) {
			$nilai_akhir = 'D';
		} else {
			$nilai_akhir = 'E';
		}

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
			'title' => "Nilai Proposal",
			'content' => 'score/proposal/view_nilai',
			'dosuji1' => $dosuji1->nama,
			'dosuji1_nidn' => $dosuji1->npm,
			'dosuji2' => $dosuji2->nama,
			'dosuji2_nidn' => $dosuji2->npm,
			'dospem1' => $dospem1->nama,
			'dospem1_nidn' => $dospem1->npm,
			'dospem2' => $dospem2->nama,
			'dospem2_nidn' => $dospem2->npm,
			'judul' => $data->judul,
			'mahasiswa' => $mahasiswa->nama,
			'angkatan' => $mahasiswa->angkatan,
			'npm' => $mahasiswa->npm,
			'now' => $now,
			'room' => $room->nama,
			'bimbingan_ketekunan_1' => $nilaiDospem1->bimbingan_ketekunan,
			'bimbingan_adab_1' => $nilaiDospem1->bimbingan_adab,
			'bimbingan_kemandirian_1' => $nilaiDospem1->bimbingan_kemandirian,
			'total_c_1' => $nilaiDospem1->total_c,
			'rata_c_1' => $nilaiDospem1->rata_c,
			'naskah_penulisan_1' => $nilaiDospem1->naskah_penulisan,
			'naskah_pemikiran_1' => $nilaiDospem1->naskah_pemikiran,
			'naskah_kajian_1' => $nilaiDospem1->naskah_kajian,
			'naskah_metode_1' => $nilaiDospem1->naskah_metode,
			'naskah_hasil_1' => $nilaiDospem1->naskah_hasil,
			'naskah_kesimpulan_1' => $nilaiDospem1->naskah_kesimpulan,
			'naskah_kepustakaan_1' => $nilaiDospem1->naskah_kepustakaan,
			'bs_naskah_penulisan_1' => $nilaiDospem1->bs_naskah_penulisan,
			'bs_naskah_pemikiran_1' => $nilaiDospem1->bs_naskah_pemikiran,
			'bs_naskah_kajian_1' => $nilaiDospem1->bs_naskah_kajian,
			'bs_naskah_metode_1' => $nilaiDospem1->bs_naskah_metode,
			'bs_naskah_hasil_1' => $nilaiDospem1->bs_naskah_hasil,
			'bs_naskah_kesimpulan_1' => $nilaiDospem1->bs_naskah_kesimpulan,
			'bs_naskah_kepustakaan_1' => $nilaiDospem1->bs_naskah_kepustakaan,
			'total_a_1' => $nilaiDospem1->total_a,
			'rata_a_1' => $nilaiDospem1->rata_a,
			'pelaksanaan_presentasi_1' => $nilaiDospem1->pelaksanaan_presentasi,
			'pelaksanaan_penguasaan_1' => $nilaiDospem1->pelaksanaan_penguasaan,
			'pelaksanaan_argumentasi_1' => $nilaiDospem1->pelaksanaan_argumentasi,
			'bs_pelaksanaan_presentasi_1' => $nilaiDospem1->bs_pelaksanaan_presentasi,
			'bs_pelaksanaan_penguasaan_1' => $nilaiDospem1->bs_pelaksanaan_penguasaan,
			'bs_pelaksanaan_argumentasi_1' => $nilaiDospem1->bs_pelaksanaan_argumentasi,
			'total_b_1' => $nilaiDospem1->total_b,
			'rata_b_1' => $nilaiDospem1->rata_b,
			'bimbingan_ketekunan_2' => $nilaiDospem2->bimbingan_ketekunan,
			'bimbingan_adab_2' => $nilaiDospem2->bimbingan_adab,
			'bimbingan_kemandirian_2' => $nilaiDospem2->bimbingan_kemandirian,
			'total_c_2' => $nilaiDospem2->total_c,
			'rata_c_2' => $nilaiDospem2->rata_c,
			'naskah_penulisan_2' => $nilaiDospem2->naskah_penulisan,
			'naskah_pemikiran_2' => $nilaiDospem2->naskah_pemikiran,
			'naskah_kajian_2' => $nilaiDospem2->naskah_kajian,
			'naskah_metode_2' => $nilaiDospem2->naskah_metode,
			'naskah_hasil_2' => $nilaiDospem2->naskah_hasil,
			'naskah_kesimpulan_2' => $nilaiDospem2->naskah_kesimpulan,
			'naskah_kepustakaan_2' => $nilaiDospem2->naskah_kepustakaan,
			'bs_naskah_penulisan_2' => $nilaiDospem2->bs_naskah_penulisan,
			'bs_naskah_pemikiran_2' => $nilaiDospem2->bs_naskah_pemikiran,
			'bs_naskah_kajian_2' => $nilaiDospem2->bs_naskah_kajian,
			'bs_naskah_metode_2' => $nilaiDospem2->bs_naskah_metode,
			'bs_naskah_hasil_2' => $nilaiDospem2->bs_naskah_hasil,
			'bs_naskah_kesimpulan_2' => $nilaiDospem2->bs_naskah_kesimpulan,
			'bs_naskah_kepustakaan_2' => $nilaiDospem2->bs_naskah_kepustakaan,
			'total_a_2' => $nilaiDospem2->total_a,
			'rata_a_2' => $nilaiDospem2->rata_a,
			'pelaksanaan_presentasi_2' => $nilaiDospem2->pelaksanaan_presentasi,
			'pelaksanaan_penguasaan_2' => $nilaiDospem2->pelaksanaan_penguasaan,
			'pelaksanaan_argumentasi_2' => $nilaiDospem2->pelaksanaan_argumentasi,
			'bs_pelaksanaan_presentasi_2' => $nilaiDospem2->bs_pelaksanaan_presentasi,
			'bs_pelaksanaan_penguasaan_2' => $nilaiDospem2->bs_pelaksanaan_penguasaan,
			'bs_pelaksanaan_argumentasi_2' => $nilaiDospem2->bs_pelaksanaan_argumentasi,
			'total_b_2' => $nilaiDospem2->total_b,
			'rata_b_2' => $nilaiDospem2->rata_b,
			'naskah_penulisan_3' => $nilaiDosuji1->naskah_penulisan,
			'naskah_pemikiran_3' => $nilaiDosuji1->naskah_pemikiran,
			'naskah_kajian_3' => $nilaiDosuji1->naskah_kajian,
			'naskah_metode_3' => $nilaiDosuji1->naskah_metode,
			'naskah_hasil_3' => $nilaiDosuji1->naskah_hasil,
			'naskah_kesimpulan_3' => $nilaiDosuji1->naskah_kesimpulan,
			'naskah_kepustakaan_3' => $nilaiDosuji1->naskah_kepustakaan,
			'bs_naskah_penulisan_3' => $nilaiDosuji1->bs_naskah_penulisan,
			'bs_naskah_pemikiran_3' => $nilaiDosuji1->bs_naskah_pemikiran,
			'bs_naskah_kajian_3' => $nilaiDosuji1->bs_naskah_kajian,
			'bs_naskah_metode_3' => $nilaiDosuji1->bs_naskah_metode,
			'bs_naskah_hasil_3' => $nilaiDosuji1->bs_naskah_hasil,
			'bs_naskah_kesimpulan_3' => $nilaiDosuji1->bs_naskah_kesimpulan,
			'bs_naskah_kepustakaan_3' => $nilaiDosuji1->bs_naskah_kepustakaan,
			'total_a_3' => $nilaiDosuji1->total_a,
			'rata_a_3' => $nilaiDosuji1->rata_a,
			'pelaksanaan_presentasi_3' => $nilaiDosuji1->pelaksanaan_presentasi,
			'pelaksanaan_penguasaan_3' => $nilaiDosuji1->pelaksanaan_penguasaan,
			'pelaksanaan_argumentasi_3' => $nilaiDosuji1->pelaksanaan_argumentasi,
			'bs_pelaksanaan_presentasi_3' => $nilaiDosuji1->bs_pelaksanaan_presentasi,
			'bs_pelaksanaan_penguasaan_3' => $nilaiDosuji1->bs_pelaksanaan_penguasaan,
			'bs_pelaksanaan_argumentasi_3' => $nilaiDosuji1->bs_pelaksanaan_argumentasi,
			'total_b_3' => $nilaiDosuji1->total_b,
			'rata_b_3' => $nilaiDosuji1->rata_b,
			'naskah_penulisan_4' => $nilaiDosuji2->naskah_penulisan,
			'naskah_pemikiran_4' => $nilaiDosuji2->naskah_pemikiran,
			'naskah_kajian_4' => $nilaiDosuji2->naskah_kajian,
			'naskah_metode_4' => $nilaiDosuji2->naskah_metode,
			'naskah_hasil_4' => $nilaiDosuji2->naskah_hasil,
			'naskah_kesimpulan_4' => $nilaiDosuji2->naskah_kesimpulan,
			'naskah_kepustakaan_4' => $nilaiDosuji2->naskah_kepustakaan,
			'bs_naskah_penulisan_4' => $nilaiDosuji2->bs_naskah_penulisan,
			'bs_naskah_pemikiran_4' => $nilaiDosuji2->bs_naskah_pemikiran,
			'bs_naskah_kajian_4' => $nilaiDosuji2->bs_naskah_kajian,
			'bs_naskah_metode_4' => $nilaiDosuji2->bs_naskah_metode,
			'bs_naskah_hasil_4' => $nilaiDosuji2->bs_naskah_hasil,
			'bs_naskah_kesimpulan_4' => $nilaiDosuji2->bs_naskah_kesimpulan,
			'bs_naskah_kepustakaan_4' => $nilaiDosuji2->bs_naskah_kepustakaan,
			'total_a_4' => $nilaiDosuji2->total_a,
			'rata_a_4' => $nilaiDosuji2->rata_a,
			'pelaksanaan_presentasi_4' => $nilaiDosuji2->pelaksanaan_presentasi,
			'pelaksanaan_penguasaan_4' => $nilaiDosuji2->pelaksanaan_penguasaan,
			'pelaksanaan_argumentasi_4' => $nilaiDosuji2->pelaksanaan_argumentasi,
			'bs_pelaksanaan_presentasi_4' => $nilaiDosuji2->bs_pelaksanaan_presentasi,
			'bs_pelaksanaan_penguasaan_4' => $nilaiDosuji2->bs_pelaksanaan_penguasaan,
			'bs_pelaksanaan_argumentasi_4' => $nilaiDosuji2->bs_pelaksanaan_argumentasi,
			'total_b_4' => $nilaiDosuji2->total_b,
			'rata_b_4' => $nilaiDosuji2->rata_b,
			'rata_bimbingan_dospem' => $rata_bimbingan,
			'rata_naskah_dospem' => $rata_naskah_dospem,
			'rata_pelaksanaan_dospem' => $rata_pelaksanaan_dospem,
			'rata_naskah_dosuji' => $rata_naskah_dosuji,
			'rata_pelaksanaan_dosuji' => $rata_pelaksanaan_dosuji,
			'bs_rata_bimbingan' => $bs_rata_bimbingan,
			'bs_rata_naskah' => $bs_rata_naskah,
			'bs_rata_pelaksanaan' => $bs_rata_pelaksanaan,
			'skor_total' => $skor_total,
			'skor_akhir' => $skor_akhir,
			'nilai_akhir' => $nilai_akhir
		];
		$this->load->view($overlay, $data);
	}


	public function dosen()
	{
		$allowed_group_ids = [2, 3];

		if (!in_array($this->session->userdata('group_id'), $allowed_group_ids)) {
			redirect('error404');
		}

		$id = $this->session->userdata('user_id');

		$dosuji1 = $this->Proscore_model->getDosuji1($id);
		$dosuji2 = $this->Proscore_model->getDosuji2($id);
		$dospem1 = $this->Proscore_model->getDospem1($id);
		$dospem2 = $this->Proscore_model->getDospem2($id);
		$data = [
			'title' => "Penilaian Ujian Proposal",
			'content' => 'score/proposal/dosen/dosen',
			'dosuji1' => $dosuji1,
			'dosuji2' => $dosuji2,
			'dospem1' => $dospem1,
			'dospem2' => $dospem2
		];

		if ($this->session->userdata('group_id') == 2) {
			$template = 'template/overlay/dosen';
		} elseif ($this->session->userdata('group_id') == 3) {
			$template = 'template/overlay/koordinator';
		}
		$this->load->view($template, $data);
	}

	public function nilai_pembimbing($id)
	{
		$allowed_group_ids = [2, 3];

		if (!in_array($this->session->userdata('group_id'), $allowed_group_ids)) {
			redirect('error404');
		}

		$ujian = $this->Proscore_model->getUjian($id);
		$data = [
			'title' => "Penilaian Ujian Proposal",
			'content' => 'score/proposal/dosen/nilai_dospem',
			'ujian' => $ujian,
		];
		$this->load->view('template/overlay/dosen', $data);
	}

	public function insert_nilai_pembimbing()
	{

		$id = $this->input->post('id');

		$naskah_penulisan = $this->input->post('naskah_penulisan');
		$naskah_pemikiran = $this->input->post('naskah_pemikiran');
		$naskah_kajian = $this->input->post('naskah_kajian');
		$naskah_metode = $this->input->post('naskah_metode');
		$naskah_hasil = $this->input->post('naskah_hasil');
		$naskah_kesimpulan = $this->input->post('naskah_kesimpulan');
		$naskah_kepustakaan = $this->input->post('naskah_kepustakaan');

		$bs_naskah_penulisan = $naskah_penulisan * 15;
		$bs_naskah_pemikiran = $naskah_pemikiran * 15;
		$bs_naskah_kajian = $naskah_kajian * 15;
		$bs_naskah_metode = $naskah_metode * 15;
		$bs_naskah_hasil = $naskah_hasil * 20;
		$bs_naskah_kesimpulan = $naskah_kesimpulan * 10;
		$bs_naskah_kepustakaan = $naskah_kepustakaan * 10;

		$total_a = $bs_naskah_penulisan + $bs_naskah_pemikiran + $bs_naskah_kajian + $bs_naskah_metode + $bs_naskah_hasil + $bs_naskah_kesimpulan + $bs_naskah_kepustakaan;
		$rata_a = $total_a / 100;

		$pelaksanaan_presentasi = $this->input->post('pelaksanaan_presentasi');
		$pelaksanaan_penguasaan = $this->input->post('pelaksanaan_penguasaan');
		$pelaksanaan_argumentasi = $this->input->post('pelaksanaan_argumentasi');

		$bs_pelaksanaan_presentasi = $pelaksanaan_presentasi * 20;
		$bs_pelaksanaan_penguasaan = $pelaksanaan_penguasaan * 50;
		$bs_pelaksanaan_argumentasi = $pelaksanaan_argumentasi * 30;

		$total_b = $bs_pelaksanaan_presentasi + $bs_pelaksanaan_penguasaan + $bs_pelaksanaan_argumentasi;
		$rata_b = $total_b / 100;

		$bimbingan_ketekunan = $this->input->post('bimbingan_ketekunan');
		$bimbingan_adab = $this->input->post('bimbingan_adab');
		$bimbingan_kemandirian = $this->input->post('bimbingan_kemandirian');

		$total_c = $bimbingan_ketekunan + $bimbingan_adab + $bimbingan_kemandirian;
		$rata_c = $total_c / 3;

		$data = [
			'naskah_penulisan' => $naskah_penulisan,
			'naskah_pemikiran' => $naskah_pemikiran,
			'naskah_kajian' => $naskah_kajian,
			'naskah_metode' => $naskah_metode,
			'naskah_hasil' => $naskah_hasil,
			'naskah_kesimpulan' => $naskah_kesimpulan,
			'naskah_kepustakaan' => $naskah_kepustakaan,
			'bs_naskah_penulisan' => $bs_naskah_penulisan,
			'bs_naskah_pemikiran' => $bs_naskah_pemikiran,
			'bs_naskah_kajian' => $bs_naskah_kajian,
			'bs_naskah_metode' => $bs_naskah_metode,
			'bs_naskah_hasil' => $bs_naskah_hasil,
			'bs_naskah_kesimpulan' => $bs_naskah_kesimpulan,
			'bs_naskah_kepustakaan' => $bs_naskah_kepustakaan,
			'total_a' => $total_a,
			'rata_a' => $rata_a,
			'pelaksanaan_presentasi' => $pelaksanaan_presentasi,
			'pelaksanaan_penguasaan' => $pelaksanaan_penguasaan,
			'pelaksanaan_argumentasi' => $pelaksanaan_argumentasi,
			'bs_pelaksanaan_presentasi' => $bs_pelaksanaan_presentasi,
			'bs_pelaksanaan_penguasaan' => $bs_pelaksanaan_penguasaan,
			'bs_pelaksanaan_argumentasi' => $bs_pelaksanaan_argumentasi,
			'total_b' => $total_b,
			'rata_b' => $rata_b,
			'bimbingan_ketekunan' => $bimbingan_ketekunan,
			'bimbingan_adab' => $bimbingan_adab,
			'bimbingan_kemandirian' => $bimbingan_kemandirian,
			'total_c' => $total_c,
			'rata_c' => $rata_c,
		];

		$this->Proscore_model->insertNilai($id, $data);
		$this->session->set_flashdata('success', 'Nilai berhasil disimpan');

		$getNilai = $this->db->where('id', $id)->get('pro_nilai')->row();
		$getRegister = $this->db->where('id', $getNilai->pro_register_id)->get('pro_register')->row();
		$getTitle = $this->db->where('id', $getRegister->title_id)->get('title')->row();

		$nilaiDospem1 = $this->Proscore_model->getNilaiDospem1($getRegister->id, $getTitle->dospem_1_id);
		$nilaiDospem2 = $this->Proscore_model->getNilaiDospem2($getRegister->id, $getTitle->dospem_2_id);
		$nilaiDosuji1 = $this->Proscore_model->getNilaiDosuji1($getRegister->id, $getTitle->dosuji_1_id);
		$nilaiDosuji2 = $this->Proscore_model->getNilaiDosuji2($getRegister->id, $getTitle->dosuji_2_id);

		$rata_bimbingan = ($nilaiDospem1->rata_c + $nilaiDospem2->rata_c) / 2;

		$rata_naskah_dospem = ($nilaiDospem1->rata_a + $nilaiDospem2->rata_a) / 2;
		$rata_pelaksanaan_dospem = ($nilaiDospem1->rata_b + $nilaiDospem2->rata_b) / 2;
		$rata_naskah_dosuji = ($nilaiDosuji1->rata_a + $nilaiDosuji2->rata_a) / 2;
		$rata_pelaksanaan_dosuji = ($nilaiDosuji1->rata_b + $nilaiDosuji2->rata_b) / 2;

		$rata_naskah = ($rata_naskah_dospem + $rata_naskah_dosuji) / 2;
		$rata_pelaksanaan = ($rata_pelaksanaan_dospem + $rata_pelaksanaan_dosuji) / 2;

		$bs_rata_bimbingan = $rata_bimbingan * 20;
		$bs_rata_naskah = $rata_naskah * 30;
		$bs_rata_pelaksanaan = $rata_pelaksanaan * 50;

		$skor_total = $bs_rata_bimbingan + $bs_rata_naskah + $bs_rata_pelaksanaan;
		$skor_akhir = $skor_total / 100;

		if (!empty($nilaiDospem1->rata_a) && !empty($nilaiDospem2->rata_a) && !empty($nilaiDosuji1->rata_a) && !empty($nilaiDosuji2->rata_a)) {
			$status = 'Selesai';
		} else {
			$status = 'Terdaftar';
		}

		$data2 = [
			'status_ujian_proposal' => $status
		];

		$this->Proscore_model->insertNilaiTitle($getTitle->id, $data2);

		$data3 = [
			'nilai' => $skor_akhir,
		];

		$this->Proscore_model->insertNilaiRegister($getRegister->id, $data3);

		redirect('score_proposal');
	}

	public function nilai_penguji($id)
	{
		$allowed_group_ids = [2, 3];

		if (!in_array($this->session->userdata('group_id'), $allowed_group_ids)) {
			redirect('error404');
		}

		$ujian = $this->Proscore_model->getUjian($id);
		$data = [
			'title' => "Penilaian Ujian Proposal",
			'content' => 'score/proposal/dosen/nilai_dosuji',
			'ujian' => $ujian
		];
		$this->load->view('template/overlay/dosen', $data);
	}

	public function insert_nilai_penguji()
	{
		$id = $this->input->post('id');

		$naskah_penulisan = $this->input->post('naskah_penulisan');
		$naskah_pemikiran = $this->input->post('naskah_pemikiran');
		$naskah_kajian = $this->input->post('naskah_kajian');
		$naskah_metode = $this->input->post('naskah_metode');
		$naskah_hasil = $this->input->post('naskah_hasil');
		$naskah_kesimpulan = $this->input->post('naskah_kesimpulan');
		$naskah_kepustakaan = $this->input->post('naskah_kepustakaan');

		$bs_naskah_penulisan = $naskah_penulisan * 15;
		$bs_naskah_pemikiran = $naskah_pemikiran * 15;
		$bs_naskah_kajian = $naskah_kajian * 15;
		$bs_naskah_metode = $naskah_metode * 15;
		$bs_naskah_hasil = $naskah_hasil * 20;
		$bs_naskah_kesimpulan = $naskah_kesimpulan * 10;
		$bs_naskah_kepustakaan = $naskah_kepustakaan * 10;

		$total_a = $bs_naskah_penulisan + $bs_naskah_pemikiran + $bs_naskah_kajian + $bs_naskah_metode + $bs_naskah_hasil + $bs_naskah_kesimpulan + $bs_naskah_kepustakaan;
		$rata_a = $total_a / 100;

		$pelaksanaan_presentasi = $this->input->post('pelaksanaan_presentasi');
		$pelaksanaan_penguasaan = $this->input->post('pelaksanaan_penguasaan');
		$pelaksanaan_argumentasi = $this->input->post('pelaksanaan_argumentasi');

		$bs_pelaksanaan_presentasi = $pelaksanaan_presentasi * 20;
		$bs_pelaksanaan_penguasaan = $pelaksanaan_penguasaan * 50;
		$bs_pelaksanaan_argumentasi = $pelaksanaan_argumentasi * 30;

		$total_b = $bs_pelaksanaan_presentasi + $bs_pelaksanaan_penguasaan + $bs_pelaksanaan_argumentasi;
		$rata_b = $total_b / 100;

		$data = [
			'naskah_penulisan' => $naskah_penulisan,
			'naskah_pemikiran' => $naskah_pemikiran,
			'naskah_kajian' => $naskah_kajian,
			'naskah_metode' => $naskah_metode,
			'naskah_hasil' => $naskah_hasil,
			'naskah_kesimpulan' => $naskah_kesimpulan,
			'naskah_kepustakaan' => $naskah_kepustakaan,
			'bs_naskah_penulisan' => $bs_naskah_penulisan,
			'bs_naskah_pemikiran' => $bs_naskah_pemikiran,
			'bs_naskah_kajian' => $bs_naskah_kajian,
			'bs_naskah_metode' => $bs_naskah_metode,
			'bs_naskah_hasil' => $bs_naskah_hasil,
			'bs_naskah_kesimpulan' => $bs_naskah_kesimpulan,
			'bs_naskah_kepustakaan' => $bs_naskah_kepustakaan,
			'total_a' => $total_a,
			'rata_a' => $rata_a,
			'pelaksanaan_presentasi' => $pelaksanaan_presentasi,
			'pelaksanaan_penguasaan' => $pelaksanaan_penguasaan,
			'pelaksanaan_argumentasi' => $pelaksanaan_argumentasi,
			'bs_pelaksanaan_presentasi' => $bs_pelaksanaan_presentasi,
			'bs_pelaksanaan_penguasaan' => $bs_pelaksanaan_penguasaan,
			'bs_pelaksanaan_argumentasi' => $bs_pelaksanaan_argumentasi,
			'total_b' => $total_b,
			'rata_b' => $rata_b,
		];

		$this->Proscore_model->insertNilai($id, $data);
		$this->session->set_flashdata('success', 'Nilai berhasil disimpan');

		$getNilai = $this->db->where('id', $id)->get('pro_nilai')->row();
		$getRegister = $this->db->where('id', $getNilai->pro_register_id)->get('pro_register')->row();
		$getTitle = $this->db->where('id', $getRegister->title_id)->get('title')->row();

		$nilaiDospem1 = $this->Proscore_model->getNilaiDospem1($getRegister->id, $getTitle->dospem_1_id);
		$nilaiDospem2 = $this->Proscore_model->getNilaiDospem2($getRegister->id, $getTitle->dospem_2_id);
		$nilaiDosuji1 = $this->Proscore_model->getNilaiDosuji1($getRegister->id, $getTitle->dosuji_1_id);
		$nilaiDosuji2 = $this->Proscore_model->getNilaiDosuji2($getRegister->id, $getTitle->dosuji_2_id);

		$rata_bimbingan = ($nilaiDospem1->rata_c + $nilaiDospem2->rata_c) / 2;

		$rata_naskah_dospem = ($nilaiDospem1->rata_a + $nilaiDospem2->rata_a) / 2;
		$rata_pelaksanaan_dospem = ($nilaiDospem1->rata_b + $nilaiDospem2->rata_b) / 2;
		$rata_naskah_dosuji = ($nilaiDosuji1->rata_a + $nilaiDosuji2->rata_a) / 2;
		$rata_pelaksanaan_dosuji = ($nilaiDosuji1->rata_b + $nilaiDosuji2->rata_b) / 2;

		$rata_naskah = ($rata_naskah_dospem + $rata_naskah_dosuji) / 2;
		$rata_pelaksanaan = ($rata_pelaksanaan_dospem + $rata_pelaksanaan_dosuji) / 2;

		$bs_rata_bimbingan = $rata_bimbingan * 20;
		$bs_rata_naskah = $rata_naskah * 30;
		$bs_rata_pelaksanaan = $rata_pelaksanaan * 50;

		$skor_total = $bs_rata_bimbingan + $bs_rata_naskah + $bs_rata_pelaksanaan;
		$skor_akhir = $skor_total / 100;

		if (!empty($nilaiDospem1->rata_a) && !empty($nilaiDospem2->rata_a) && !empty($nilaiDosuji1->rata_a) && !empty($nilaiDosuji2->rata_a)) {
			$status = 'Selesai';
		} else {
			$status = 'Terdaftar';
		}

		$data2 = [
			'status_ujian_proposal' => $status
		];

		$this->Proscore_model->insertNilaiTitle($getTitle->id, $data2);

		$data3 = [
			'nilai' => $skor_akhir,
		];

		$this->Proscore_model->insertNilaiRegister($getRegister->id, $data3);

		redirect('score_proposal');
	}

	public function admin()
	{
		if ($this->session->userdata('group_id') != 4) {
			redirect('error404');
		}

		$ujian = $this->Proscore_model->getNilaiAll();
		$data = [
			'title' => "Nilai Ujian Proposal",
			'content' => 'score/proposal/admin/admin',
			'ujian' => $ujian
		];
		$this->load->view('template/overlay/admin', $data);
	}

	public function koordinator()
	{

		if ($this->session->userdata('group_id') != 3) {
			redirect('error404');
		}

		$ujian = $this->Proscore_model->getNilaiAll();
		$data = [
			'title' => "Nilai Ujian Proposal",
			'content' => 'score/proposal/koordinator/koordinator',
			'ujian' => $ujian
		];
		$this->load->view('template/overlay/koordinator', $data);
	}

	public function update_nilai()
	{
		$pro_id = $this->input->post('pro_id');
		$nilai = $this->input->post('value');

		$this->Proscore_model->update_nilai($pro_id, $nilai);

		redirect('score_proposal/koordinator');
	}
}
