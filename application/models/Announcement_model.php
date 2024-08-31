<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Announcement_model extends CI_Model
{
	private $table = 'users';

	public function __construct()
	{
		parent::__construct();
	}

	public function get()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('announcement');
		return $query->result();
	}

	public function submit($data)
	{
		$this->db->insert('announcement', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('announcement');
	}

	public function get_this($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('announcement');
		return $query->row();
	}

	public function set($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('announcement', $data);
	}
}
