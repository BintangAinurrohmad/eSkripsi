<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tracking_mhs extends CI_Controller
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


    public function track_mhs()
    {
        $user_id = $this->session->userdata('user_id');

        $data = [
            'title' => "Progress Mahasiswa",
            'content' => 'progress/progress_mhs',
        ];

        $angkatan = $this->input->get('angkatan');
        $npm = $this->input->get('npm');
        $status_terakhir = $this->input->get('status_terakhir');
        $dospem_1_nama = $this->input->get('dospem_1_nama');
        $dospem_2_nama = $this->input->get('dospem_2_nama');

        // Memuat model sebelum digunakan
        $data['dosen_list'] = $this->Progress_proposal_model->get_filtered_data(null, null, null, null, null, 'dosen');
        $data['mahasiswa_data'] = $this->Progress_proposal_model->get_filtered_data($angkatan, $npm, $status_terakhir, $dospem_1_nama, $dospem_2_nama, 'mahasiswa');

        $this->load->view('template/overlay/koordinator', $data);
    }



    public function word_export()
    {
        // Load the necessary model
        $this->load->model('Progress_proposal_model');

        // Fetch the filtered data using the same filters as in the track_mhs method
        $angkatan = $this->input->get('angkatan');
        $npm = $this->input->get('npm');
        $status_terakhir = $this->input->get('status_terakhir');
        $dospem_1_nama = $this->input->get('dospem_1_nama');
        $dospem_2_nama = $this->input->get('dospem_2_nama');

        $mahasiswa_data = $this->Progress_proposal_model->get_filtered_data($angkatan, $npm, $status_terakhir, $dospem_1_nama, $dospem_2_nama, 'mahasiswa');

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


}
