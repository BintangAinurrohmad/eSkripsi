<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Progress_proposal extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

		$this->load->model('Progress_proposal_model'); // Load the model
		$this->load->model('Title_model'); // Load the model

		include_once(APPPATH . "third_party/PhpWord/PhpWordAutoloader.php");
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

	public function admin()
	{
		$data = [
			'title' => "Progress Proposal",
			'content' => 'progress/proposal/admin/admin',
		];

		$data['proposal_data'] = $this->Progress_proposal_model->get_mahasiswa_for_koordinator();
		$this->load->view('template/overlay/admin', $data);
	}



	public function admin1($id)
	{
		$data = array('data_proposal' => $this->Progress_proposal_model->get_proposal_data_by_mahasiswa_foradmin($id));
		$data['title'] = "Progress Proposal";
		$data['content'] = 'progress/proposal/admin/admin1';
		$data['mahasiswa_id'] = $id;

		$this->load->view('template/overlay/admin', $data);
	}



	public function mahasiswa()
	{
		$user_id = $this->session->userdata('user_id');

		$data = array('data_proposal' => $this->Progress_proposal_model->get_proposal_data_by_user_id($user_id));
		$judul = $this->Title_model->getMyLastAccTitle($user_id);

		$data['my_title'] = $judul;
		$data['title'] = "Progress Proposal";
		$data['content'] = 'progress/proposal/mahasiswa/mahasiswa';

		$this->load->view('template/overlay/mahasiswa', $data);
	}

	public function download_log()
	{
		$this->load->helper('download');
		$this->load->dbutil(); // Load the dbutil library

		$query = $this->db->query("SELECT * FROM pro_progress"); // Your database query
		$delimiter = ","; // Set the delimiter for the CSV file
		$newline = "\r\n"; // Set the newline character for the CSV file

		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline); // Generate CSV data

		force_download('data_proposal.csv', $data); // Download the CSV file
	}

	public function download_bukti($id)
	{
		$data = $this->Progress_proposal_model->get_bukti_by_id($id);

		if ($data) {
			$file_path = "file/proposal/bukti/" . $data['bukti']; // Get the full image path
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
					case 'docx':
						header('Content-Type: application/docx');
						break;
					case 'doc':
						header('Content-Type: application/doc');
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

	//bintang 13/08/2024
	public function view_file($folder, $file)
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

		if ($folder == "bukti") {
			$title = "bukti bimbingan";
		}

		$data = [
			'title' => 'Lihat ' . $title,
			'content' => 'progress/proposal/view_file',
			'folder' => $folder,
			'file' => $file
		];
		$this->load->view($overlay, $data);
	}


	public function delete_progress($id)
	{
		$this->Progress_proposal_model->delete_progress($id);
		redirect('Progress_proposal/mahasiswa');
	}

	public function progress_proposal_download_dospem1()
	{
		$user_id = $this->session->userdata('user_id');
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("template_bimbingan_prop.docx");

		$judul = $this->Progress_proposal_model->get_judul($user_id);
		$data = $this->Progress_proposal_model->download_progress_proposal_dospem($user_id, $judul[0]->dospem_1_id);

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
				'approved' => 'Disetujui',
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

			$nameFile = $data[0]->nama_mahasiswa . "- Berita Acara Bimbingan proposal dospem 1.docx";

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
			redirect('/Progress_proposal/mahasiswa');
		}
	}


	public function progress_proposal_download_dospem2()
	{
		$user_id = $this->session->userdata('user_id');
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor("template_bimbingan_prop.docx");

		$judul = $this->Progress_proposal_model->get_judul($user_id);
		$data = $this->Progress_proposal_model->download_progress_proposal_dospem($user_id, $judul[0]->dospem_2_id);

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
				'approved' => 'Disetujui',
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

			$nameFile = $data[0]->nama_mahasiswa . "- Berita Acara Bimbingan proposal dospem 2.docx";

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
			redirect('/Progress_proposal/mahasiswa');
		}
	}



	public function mahasiswa1()
	{
		$user_id = $this->session->userdata('user_id');

		$data['title'] = "Progress Proposal";
		if (count($this->Progress_proposal_model->is_has_accepted_title($user_id)) > 0) {
			$data['content'] = 'progress/proposal/mahasiswa/mahasiswa1';

			// Get data from database
			$data['pembimbing_list'] = $this->Progress_proposal_model->get_pembimbing($user_id);
			$data['judul_list'] = $this->Title_model->getMyLastAccTitle($user_id);

			$this->load->view('template/overlay/mahasiswa', $data);
		} else {
			$data['error'] = 'Mohon maaf judul anda belum diterima';
			$data['content'] = 'progress/proposal/mahasiswa/message';
			$this->load->view('template/overlay/mahasiswa', $data);
		}
	}

	//bintang
	public function insert_bimbingan()
	{
		if ($this->input->post()) {
			$config['upload_path'] = './file/proposal/bukti/';
			//13/08/2024
			$config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
			$config['max_size'] = '3000';
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('bukti')) {
				$data['error'] = $this->upload->display_errors();
			} else {
				$upload_data = $this->upload->data();
				$bukti =  $upload_data['file_name'];

				$data = array(
					'tanggal' => $this->input->post('tanggal'),
					'judul_id' => $this->input->post('judul'),
					'pembimbing' => $this->input->post('pembimbing'),
					'pembahasan' => $this->input->post('pembahasan'),
					'bukti' => $bukti,
					'status' => 'pending'
				);

				if ($this->Progress_proposal_model->insert_progress($data)) {
					$data['success'] = 'Progress proposal submitted successfully!';

					// Get mahasiswa ID
					$judul_id = $this->input->post('judul');
					$judul_data = $this->db->where('id', $judul_id)->get('title')->first_row();
					$mahasiswa_id = $judul_data->mahasiswa;

					// Insert notification for mahasiswa
					$notif_data = array(
						'user_id' => $mahasiswa_id,
						'judul' => 'Bimbingan Proposal Diserahkan',
						'pesan' => "Bimbingan proposal anda berhasil diserahkan kepada dosen pembimbing anda.",
						'type' => 'success',
						'page_type' => 'new_progress'
					);
					$this->db->insert('notifikasi', $notif_data);

					// Insert notification for dosen pembimbing
					$pembimbing_id = $this->input->post('pembimbing');
					if ($pembimbing_id) {
						$notif_data = array(
							'user_id' => $pembimbing_id,
							'judul' => 'Bimbingan Proposal Baru',
							'pesan' => "mahasiswa bimbingan anda telah menyerahkan BIMBINGAN proposal, segera cek progress mahasiswa bimbingan anda.",
							'type' => 'info',
							'page_type' => 'new_progress'
						);
						$this->db->insert('notifikasi', $notif_data);
					}
				} else {
					$data['error'] = 'Failed to submit progress proposal.';
				}
			}
			redirect('Progress_proposal/mahasiswa');
		}
	}



	public function dosen()
	{
		$user_id = $this->session->userdata('user_id');

		$data = [
			'title' => "Progress Proposal",
			'content' => 'progress/proposal/dosen/dosen',
		];
		$data['proposal_data'] = $this->Progress_proposal_model->get_mahasiswa_for_dosen($user_id);

		$this->load->view('template/overlay/dosen', $data);
	}


	public function dosen1($id)
	{
		$dosen_id = $this->session->userdata('user_id'); // Assuming you store dosen_id in session
		$data = array('data_proposal' => $this->Progress_proposal_model->get_proposal_data_by_mahasiswa($id, $dosen_id));
		$data['title'] = "Progress Proposal";
		$data['content'] = 'progress/proposal/dosen/dosen1';
		$data['mahasiswa_id'] = $id;

		$this->load->view('template/overlay/dosen', $data);
	}


	public function update_status($id, $mahasiswa_id)
	{
		$this->load->model('Progress_proposal_model');
		$status = $this->input->post('status');
		$this->Progress_proposal_model->update_status($id, $status);
		redirect("Progress_proposal/dosen1/$mahasiswa_id");
	}



	public function dosen2()
	{
		$data = [
			'title' => "Progress Proposal",
			'content' => 'progress/proposal/dosen/dosen2',
		];
		$this->load->view('template/overlay/dosen', $data);
	}

	//revisi
	public function koordinator()
	{
		$user_id = $this->session->userdata('user_id');

		// Prepare data array with view-specific information
		$data = [
			'title' => "Progress Proposal",
			'content' => 'progress/proposal/koordinator/koordinator',
		];

		// Retrieve proposal data and mahasiswa data including dosen pembimbing
		$data['proposal_data'] = $this->Progress_proposal_model->get_mahasiswa_for_dosen($user_id);
		
		// Load the koordinator view with the data array
		$this->load->view('template/overlay/koordinator', $data);
	}

	public function track_mhs()
	{
		$user_id = $this->session->userdata('user_id');

		$data = [
			'title' => "Progress Mahasiswa",
			'content' => 'progress/proposal/koordinator/koordinator2',
		];

		$angkatan = $this->input->get('angkatan');
		$npm = $this->input->get('npm');
		$status_terakhir = $this->input->get('status_terakhir');
		$dospem_1_nama = $this->input->get('dospem_1_nama');
		$dospem_2_nama = $this->input->get('dospem_2_nama');

		$data['mahasiswa_data'] = $this->Progress_proposal_model->get_all_mahasiswa($angkatan, $npm, $status_terakhir, $dospem_1_nama, $dospem_2_nama);

		$this->load->view('template/overlay/koordinator', $data);
	}



	public function word_export()
	{
		// Load the necessary model
		$this->load->model('Progress_proposal_model');

		// Fetch the filtered data
		$angkatan = $this->input->get('angkatan');
		$npm = $this->input->get('npm');
		$status_terakhir = $this->input->get('status_terakhir');
		$mahasiswa_data = $this->Progress_proposal_model->get_all_mahasiswa($angkatan, $npm, $status_terakhir);

		// Create a new Word document
		$phpWord = new \PhpOffice\PhpWord\PhpWord();

		// Set the page orientation to landscape
		$sectionStyle = array(
			'orientation' => 'landscape',
			'marginLeft' => 600,
			'marginRight' => 600,
			'marginTop' => 600,
			'marginBottom' => 600
		);
		$section = $phpWord->addSection($sectionStyle);

		// Add table headers with border
		$tableStyle = array(
			'borderSize' => 6,
			'borderColor' => '000000',
			'cellMargin' => 50
		);
		$firstRowStyle = array('bgColor' => 'CCCCCC');
		$phpWord->addTableStyle('Fancy Table', $tableStyle, $firstRowStyle);

		$table = $section->addTable('Fancy Table');
		$table->addRow();
		$table->addCell(2000)->addText('Nama');
		$table->addCell(2000)->addText('NPM');
		$table->addCell(2000)->addText('Status Judul');
		$table->addCell(2000)->addText('Status Bimbingan Proposal');
		$table->addCell(2000)->addText('Status Ujian Proposal');
		$table->addCell(2000)->addText('Status Bimbingan Skripsi');
		$table->addCell(2000)->addText('Status Ujian Skripsi');
		$table->addCell(2000)->addText('Status Skripsi Selesai');
		$table->addCell(2000)->addText('Dosen Pembimbing 1');
		$table->addCell(2000)->addText('Dosen Pembimbing 2');

		// Populate the data
		foreach ($mahasiswa_data as $mhs) {
			$table->addRow();
			$table->addCell(2000)->addText($mhs['nama']);
			$table->addCell(2000)->addText($mhs['npm']);
			$table->addCell(2000)->addText($mhs['status_judul']);
			$table->addCell(2000)->addText($mhs['status_bimbingan_proposal']);
			$table->addCell(2000)->addText($mhs['status_ujian_proposal']);
			$table->addCell(2000)->addText($mhs['status_bimbingan_skripsi']);
			$table->addCell(2000)->addText($mhs['status_ujian_skripsi']);
			$table->addCell(2000)->addText($mhs['status_skripsi_selesai']);
			$table->addCell(2000)->addText($mhs['dospem_1_nama']);
			$table->addCell(2000)->addText($mhs['dospem_2_nama']);
		}

		// Save the file and prompt download
		$filename = 'mahasiswa_data.docx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save('php://output');
	}



	public function koordinator1($id)
	{
		$dosen_id = $this->session->userdata('user_id'); // Assuming you store dosen_id in session
		$data = array('data_proposal' => $this->Progress_proposal_model->get_proposal_data_by_mahasiswa($id, $dosen_id));
		$data['title'] = "Progress Proposal";
		$data['content'] = 'progress/proposal/koordinator/koordinator1';
		$data['mahasiswa_id'] = $id;

		$this->load->view('template/overlay/koordinator', $data);
	}

	public function mahasiswa2()
	{
		$data = [
			'title' => "Progress Proposal",
			'content' => 'progress/proposal/mahasiswa/mahasiswa2',
		];
		$this->load->view('template/overlay/mahasiswa', $data);
	}
}
