<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Announcement extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Announcement_model');
    }

    public function index()
    {
        $allowed_group_ids = [4, 3];

        if (!in_array($this->session->userdata('group_id'), $allowed_group_ids)) {
            redirect('error404');
        }

        $pengumuman = $this->Announcement_model->get();
        $data = [
            'title' => "Pengumuman",
            'content' => 'announcement/list',
            'pengumuman' => $pengumuman
        ];

        if ($this->session->userdata('group_id') == 4) {
            $template = 'template/overlay/admin';
        } elseif ($this->session->userdata('group_id') == 3) {
            $template = 'template/overlay/koordinator';
        }
        $this->load->view($template, $data);
    }

    public function add()
    {
        $allowed_group_ids = [4, 3];

        if (!in_array($this->session->userdata('group_id'), $allowed_group_ids)) {
            redirect('error404');
        }

        $pengumuman = $this->Announcement_model->get();
        $data = [
            'title' => "Tambah Pengumuman",
            'content' => 'announcement/add',
            'pengumuman' => $pengumuman
        ];

        if ($this->session->userdata('group_id') == 4) {
            $template = 'template/overlay/admin';
        } elseif ($this->session->userdata('group_id') == 3) {
            $template = 'template/overlay/koordinator';
        }
        $this->load->view($template, $data);
    }

    public function submit()
    {
        $allowed_group_ids = [4, 3];

        if (!in_array($this->session->userdata('group_id'), $allowed_group_ids)) {
            redirect('error404');
        }

        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('content', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Semua kolom wajib diisi.');
            redirect('announcement/add');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'created_by' => $this->session->userdata('user_id')
            ];

            $this->Announcement_model->submit($data);
            $this->session->set_flashdata('success', 'Berhasil mengirim pengumuman');
            redirect('announcement');
        }
    }

    public function delete($id)
    {
        $allowed_group_ids = [4, 3];

        if (!in_array($this->session->userdata('group_id'), $allowed_group_ids)) {
            redirect('error404');
        }

        $this->Announcement_model->delete($id);
        $this->session->set_flashdata('success', 'Berhasil Menghapus Pengumuman');
        redirect('announcement');
    }

    public function edit($id)
    {
        $allowed_group_ids = [4, 3];

        if (!in_array($this->session->userdata('group_id'), $allowed_group_ids)) {
            redirect('error404');
        }

        $pengumuman = $this->Announcement_model->get_this($id);
        $data = [
            'title' => "Edit Pengumuman",
            'content' => 'announcement/edit',
            'pengumuman' => $pengumuman
        ];

        if ($this->session->userdata('group_id') == 4) {
            $template = 'template/overlay/admin';
        } elseif ($this->session->userdata('group_id') == 3) {
            $template = 'template/overlay/koordinator';
        }
        $this->load->view($template, $data);
    }

    public function set()
    {
        $allowed_group_ids = [4, 3];

        if (!in_array($this->session->userdata('group_id'), $allowed_group_ids)) {
            redirect('error404');
        }

        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('content', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Semua kolom wajib diisi.');
            redirect('announcement/add');
        } else {
            $id = $this->input->post('id');
            $data = [
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'created_by' => $this->session->userdata('user_id')
            ];

            $this->Announcement_model->set($id, $data);
            $this->session->set_flashdata('success', 'Berhasil memperbarui pengumuman');
            redirect('announcement');
        }
    }
}
