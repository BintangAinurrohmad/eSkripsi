<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Progress_skripsi extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

		$this->load->model('Progress_skripsi_model'); // Load the model
		$this->load->model('Title_model'); // Load the model

		include_once(APPPATH . "third_party/PhpWord/PhpWordAutoloader.php");
	}

	//test git

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

	public function admin()
	{
		$data = [
			'title' => "Progress Skripsi",
			'content' => 'progress/skripsi/admin/admin',
		];

		$data['skripsi_data'] = $this->Progress_skripsi_model->get_mahasiswa_for_koordinator();
		$this->load->view('template/overlay/admin', $data);
	}



	public function admin1($id)
	{
		$data = array('data_skripsi' => $this->Progress_skripsi_model->get_skripsi_data_by_mahasiswa_foradmin($id));
		$data['title'] = "Progress Skripsi";
		$data['content'] = 'progress/skripsi/admin/admin1';
		$data['mahasiswa_id'] = $id;

		$this->load->view('template/overlay/admin', $data);
	}

	public function mahasiswa()
	{
		$user_id = $this->session->userdata('user_id');

		$data = array('data_skripsi' => $this->Progress_skripsi_model->get_skripsi_data_by_user_id($user_id));
		$judul = $this->Title_model->getMyLastAccTitle($user_id);

		$data['my_title'] = $judul;
		$data['title'] = "Progress Skripsi";
		$data['content'] = 'progress/skripsi/mahasiswa/mahasiswa';

		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function download_log()
	{
		$this->load->helper('download');
		$this->load->dbutil(); // Load the dbutil library

		$query = $this->db->query("SELECT * FROM skp_progress"); // Your database query
		$delimiter = ","; // Set the delimiter for the CSV file
		$newline = "\r\n"; // Set the newline character for the CSV file

		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline); // Generate CSV data

		force_download('data_skripsi.csv', $data); // Download the CSV file
	}

	public function download_bukti($id)
	{
		$data = $this->Progress_skripsi_model->get_bukti_by_id($id);

		if ($data) {
			$file_path = "file/skripsi/bukti/" . $data['bukti']; // Get the full image path
			$file_name = basename($file_path); // Get the file name

			if (file_exists($file_path)) {
				$file_info = pathinfo($file_path);
				$file_extension = strtolower($file_info['extension']);

				// Define the correct header for different file types
				switch ($file_extension) {
					case 'jpg':
					case 'jpeg':
						header('Content-Type: image/jpeg');
						break;
					case 'png':
						header('Content-Type: image/png');
						break;
					case 'gif':
						header('Content-Type: image/gif');
						break;
					case 'pdf':
						header('Content-Type: application/pdf');
						break;
					default:
						echo "Unsupported file type.";
						return;
				}

				readfile($file_path);
			} else {
				echo "File not found.";
			}
		} else {
			echo "Data not found.";
		}
	}

	public function delete_progress($id)
	{
		$this->Progress_skripsi_model->delete_progress($id);
		redirect('Progress_skripsi/mahasiswa');
	}

	public function progress_skripsi_download_dospem1()
	{
		$user_id = $this->session->userdata('user_id');
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("template_bimbingan_prop.docx");

		$judul = $this->Progress_skripsi_model->get_judul($user_id);
		$data = $this->Progress_skripsi_model->download_progress_skripsi_dospem($user_id, $judul[0]->dospem_1_id);

		if (isset($data[0])) {

			$templateProcessor->setValues([
				'name'     => $data[0]->nama_mahasiswa,
				'npm' 	=> $data[0]->npm_mahasiswa,
				'title'	=> $data[0]->judul,
				'dospem'	=> $data[0]->nama_pembimbing,
				'dospem_type'	=> "I",
			]);

			// Membuat tabel di dalam template
			$table = new \PhpOffice\PhpWord\Element\Table(array('borderSize' => 6));

			$cellColspan = array('gridspan' => 4);
			$cellColor = array('bgColor' => 'EBECF0');

			// Tambahkan header tabel
			$table->addRow();
			$table->addCell(1000, $cellColor)->addText('No');
			$table->addCell(2500, $cellColor)->addText('Tanggal');
			$table->addCell(6000, $cellColor)->addText('Topik Bimbingan');
			$table->addCell(2500, $cellColor)->addText('Status');

			// Define status mapping
			$status_mapping = [
				'approved' => 'Diterima',
				'pending' => 'Diproses',
				'rejected' => 'Ditolak',
			];

			// Tambahkan data ke tabel
			foreach ($data as $index => $progress) {
				$table->addRow();
				$table->addCell(1000)->addText($index + 1);
				$table->addCell(2500)->addText($progress->tanggal);
				$table->addCell(6000)->addText($progress->pembahasan);
				$table->addCell(2500)->addText($status_mapping[$progress->status]);
			}

			$table->addRow();
			$table->addCell(12000, $cellColspan)->addText("Jumlah bimbingan ke pembimbing :  " . count($data) . " kali");

			$templateProcessor->setComplexBlock('progress_table', $table);

			// Simpan tabel ke dalam file sementara
			$tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
			$templateProcessor->saveAs($tempFile);

			$nameFile = $data[0]->nama_mahasiswa . "- Berita Acara Bimbingan skripsi dospem 1.docx";

			header("Content-Disposition: attachment; filename=$nameFile");
			header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($tempFile));
			readfile($tempFile);

			// Hapus file sementara
			unlink($tempFile);
		} else {
			$this->session->set_flashdata('error', 'Bimbingan tidak ditemukan');
			redirect('/Progress_skripsi/mahasiswa');
		}
	}


	public function progress_skripsi_download_dospem2()
	{
		$user_id = $this->session->userdata('user_id');
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("template_bimbingan_prop.docx");

		$judul = $this->Progress_skripsi_model->get_judul($user_id);
		$data = $this->Progress_skripsi_model->download_progress_skripsi_dospem($user_id, $judul[0]->dospem_2_id);

		if (isset($data[0])) {

			$templateProcessor->setValues([
				'name'     => $data[0]->nama_mahasiswa,
				'npm' 	=> $data[0]->npm_mahasiswa,
				'title'	=> $data[0]->judul,
				'dospem'	=> $data[0]->nama_pembimbing,
				'dospem_type'	=> "II",
			]);

			// Membuat tabel di dalam template
			$table = new \PhpOffice\PhpWord\Element\Table(array('borderSize' => 6));

			$cellColspan = array('gridspan' => 4);
			$cellColor = array('bgColor' => 'EBECF0');

			// Tambahkan header tabel
			$table->addRow();
			$table->addCell(1000, $cellColor)->addText('No');
			$table->addCell(2500, $cellColor)->addText('Tanggal');
			$table->addCell(6000, $cellColor)->addText('Topik Bimbingan');
			$table->addCell(2500, $cellColor)->addText('Status');

			// Define status mapping
			$status_mapping = [
				'approved' => 'Diterima',
				'pending' => 'Diproses',
				'rejected' => 'Ditolak',
			];

			// Tambahkan data ke tabel
			foreach ($data as $index => $progress) {
				$table->addRow();
				$table->addCell(1000)->addText($index + 1);
				$table->addCell(2500)->addText($progress->tanggal);
				$table->addCell(6000)->addText($progress->pembahasan);
				$table->addCell(2500)->addText($status_mapping[$progress->status]);
			}

			$table->addRow();
			$table->addCell(12000, $cellColspan)->addText("Jumlah bimbingan ke pembimbing :  " . count($data) . " kali");

			$templateProcessor->setComplexBlock('progress_table', $table);

			// Simpan tabel ke dalam file sementara
			$tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
			$templateProcessor->saveAs($tempFile);

			$nameFile = $data[0]->nama_mahasiswa . "- Berita Acara Bimbingan skripsi dospem 2.docx";

			header("Content-Disposition: attachment; filename=$nameFile");
			header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($tempFile));
			readfile($tempFile);

			// Hapus file sementara
			unlink($tempFile);
		} else {
			$this->session->set_flashdata('error', 'Bimbingan tidak ditemukan');
			redirect('/Progress_skripsi/mahasiswa');
		}
	}



	public function mahasiswa1()
	{
		$user_id = $this->session->userdata('user_id');

		$data['title'] = "Progress Skripsi";
		if (count($this->Progress_skripsi_model->is_has_accepted_ujian($user_id)) > 0) {
			$data['content'] = 'progress/skripsi/mahasiswa/mahasiswa1';

			// Get data from database
			$data['pembimbing_list'] = $this->Progress_skripsi_model->get_pembimbing($user_id);
			$data['judul_list'] = $this->Title_model->getMyLastAccTitle($user_id);

			$this->load->view('template/overlay/mahasiswa', $data);
		} else {
			$data['error'] = 'Mohon maaf anda belum ujian proposal';
			$data['content'] = 'progress/skripsi/mahasiswa/message';
			$this->load->view('template/overlay/mahasiswa', $data);
		}
	}

	// public function insert_bimbingan()
	// {
	// 	if ($this->input->post()) {
	// 		$config['upload_path'] = './file/skripsi/bukti/'; // Set upload path
	// 		$config['allowed_types'] = 'gif|jpg|png'; // Allowed file types
	// 		$config['max_size'] = '1024'; // Max file size in KB
	// 		$this->load->library('upload', $config);

	// 		if (!$this->upload->do_upload('bukti')) {
	// 			$data['error'] = $this->upload->display_errors(); // Display error message
	// 		} else {
	// 			$upload_data = $this->upload->data(); // Get upload data
	// 			$bukti = $upload_data['file_name']; // Get uploaded file name

	// 			$data = array(
	// 				'tanggal' => $this->input->post('tanggal'),
	// 				'judul_id' => $this->input->post('judul'),
	// 				'pembimbing' => $this->input->post('pembimbing'),
	// 				// 'bab' => $this->input->post('bab'),
	// 				'pembahasan' => $this->input->post('pembahasan'),
	// 				'bukti' => $bukti,
	// 				'status' => 'pending' // Assuming initial status is 'Diajukan'
	// 			);


	// 			if ($this->Progress_skripsi_model->insert_progress($data)) {
	// 				$data['success'] = 'Progress skripsi submitted successfully!';
	// 			} else {
	// 				$data['error'] = 'Failed to submit progress skripsi.';
	// 			}
	// 		}
	// 		return
	// 			redirect('Progress_skripsi/mahasiswa');
	// 	}
	// }

	//bintang
	public function insert_bimbingan()
	{
		if ($this->input->post()) {
			$config['upload_path'] = './file/skripsi/bukti/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '1024';
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('bukti')) {
				$data['error'] = $this->upload->display_errors();
			} else {
				$upload_data = $this->upload->data();
				$bukti = $upload_data['file_name'];

				$data = array(
					'tanggal' => $this->input->post('tanggal'),
					'judul_id' => $this->input->post('judul'),
					'pembimbing' => $this->input->post('pembimbing'),
					'pembahasan' => $this->input->post('pembahasan'),
					'bukti' => $bukti,
					'status' => 'pending'
				);

				if ($this->Progress_skripsi_model->insert_progress($data)) {
					$data['success'] = 'Progress skripsi submitted successfully!';

					// Get mahasiswa ID
					$judul_id = $this->input->post('judul');
					$judul_data = $this->db->where('id', $judul_id)->get('title')->first_row();
					$mahasiswa_id = $judul_data->mahasiswa;

					// Insert notification for mahasiswa
					$notif_data = array(
						'user_id' => $mahasiswa_id,
						'judul' => 'Progress Skripsi Diserahkan',
						'pesan' => "Bimbingan skripsi anda berhasil diserahkan kepada dosen pembimbing anda.",
						'type' => 'success'
					);
					$this->db->insert('notifikasi', $notif_data);

					// Insert notification for dosen pembimbing
					$pembimbing_id = $this->input->post('pembimbing');
					if ($pembimbing_id) {
						$notif_data = array(
							'user_id' => $pembimbing_id,
							'judul' => 'Progress Skripsi Baru',
							'pesan' => "mahasiswa bimbingan anda telah menyerahkan BIMBINGAN skripsi, segera cek progress mahasiswa bimbingan anda.",
							'type' => 'info'
						);
						$this->db->insert('notifikasi', $notif_data);
					}
				} else {
					$data['error'] = 'Failed to submit progress skripsi.';
				}
			}
			redirect('Progress_skripsi/mahasiswa');
		}
	}


	public function dosen()
	{
		$user_id = $this->session->userdata('user_id');

		$data = [
			'title' => "Progress Skripsi",
			'content' => 'progress/skripsi/dosen/dosen',
		];
		$data['skripsi_data'] = $this->Progress_skripsi_model->get_mahasiswa_for_dosen($user_id);

		$this->load->view('template/overlay/dosen', $data);
	}

	public function dosen1($id)
	{
		$dosen_id = $this->session->userdata('user_id'); // Assuming you store dosen_id in session
		$data = array('data_skripsi' => $this->Progress_skripsi_model->get_skripsi_data_by_mahasiswa($id, $dosen_id));
		$data['title'] = "Progress Skripsi";
		$data['content'] = 'progress/skripsi/dosen/dosen1';
		$data['mahasiswa_id'] = $id;

		$this->load->view('template/overlay/dosen', $data);
	}


	public function update_status($id, $mahasiswa_id)
	{
		$this->load->model('Progress_skripsi_model');
		$status = $this->input->post('status');
		$this->Progress_skripsi_model->update_status($id, $status);
		redirect("Progress_skripsi/dosen1/$mahasiswa_id");
	}



	public function dosen2()
	{
		$data = [
			'title' => "Progress Skripsi",
			'content' => 'progress/skripsi/dosen/dosen2',
		];
		$this->load->view('template/overlay/dosen', $data);
	}

	public function koordinator()
	{
		$user_id = $this->session->userdata('user_id');
		$data = [
			'title' => "Progress Skripsi",
			'content' => 'progress/skripsi/koordinator/koordinator',
		];
		$data['skripsi_data'] =
			$this->Progress_skripsi_model->get_mahasiswa_for_dosen($user_id);
		$this->load->view('template/overlay/koordinator', $data);
	}

	public function koordinator1($id)
	{
		$dosen_id = $this->session->userdata('user_id'); // Assuming you store dosen_id in session
		$data = array('data_skripsi' => $this->Progress_skripsi_model->get_skripsi_data_by_mahasiswa($id, $dosen_id));
		$data['title'] = "Progress Skripsi";
		$data['content'] = 'progress/skripsi/koordinator/koordinator1';
		$data['mahasiswa_id'] = $id;

		$this->load->view('template/overlay/koordinator', $data);
	}


	public function koordinator2()
	{
		$data = [
			'title' => "Progress Skripsi",
			'content' => 'progress/skripsi/koordinator/koordinator2',
		];
		$this->load->view('template/overlay/koordinator', $data);
	}
}
