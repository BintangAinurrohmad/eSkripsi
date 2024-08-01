<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('Notification_model'); // Load the model

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
        $user_id = $this->session->userdata('user_id');

        $data['title'] = "Notifikasi";
        $data['content'] = 'notification';
        $data['notif'] = $this->Notification_model->get_notification_by_user_id($user_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('notifikasi', array('is_read' => TRUE));

        $this->load->view('template/overlay/mahasiswa', $data);
        
    }

    public function unread_count()
    {
        $unread_notifications = $this->db->where('user_id', $this->session->userdata('user_id'))
            ->where('is_read', 0)
            ->count_all_results('notifikasi');

        echo json_encode(array('unread_count' => $unread_notifications));
    }

    public function dosen()
    {
        $user_id = $this->session->userdata('user_id');

        $data['title'] = "Notifikasi";
        $data['content'] = 'notification';
        $data['notif'] = $this->Notification_model->get_notification_by_user_id($user_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('notifikasi', array('is_read' => TRUE));

        $this->load->view('template/overlay/dosen', $data);
    }

    public function koordinator()
    {
        $user_id = $this->session->userdata('user_id');

        $data['title'] = "Notifikasi";
        $data['content'] = 'notification';
        $data['notif'] = $this->Notification_model->get_notification_by_user_id($user_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('notifikasi', array('is_read' => TRUE));

        $this->load->view('template/overlay/koordinator', $data);
    }

    public function admin()
    {
        $user_id = $this->session->userdata('user_id');

        $data['title'] = "Notifikasi";
        $data['content'] = 'notification';
        $data['notif'] = $this->Notification_model->get_notification_by_user_id($user_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('notifikasi', array('is_read' => TRUE));

        $this->load->view('template/overlay/mahasiswa', $data);
    }
}
