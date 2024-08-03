<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification_model extends CI_Model
{
    public function get_notification_by_user_id($user_id)
    {
        $this->db->select('notifikasi.*');
        $this->db->from('notifikasi');
        $this->db->where('notifikasi.user_id', $user_id);
        // $this->db->or_where('notifikasi.user_id IS NULL', null, false);
        $this->db->order_by('notifikasi.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
}
