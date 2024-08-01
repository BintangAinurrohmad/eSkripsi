<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Room_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get()
	{
		$query = $this->db->get('rooms');
		return $query->result();
	}

	public function create($data)
	{
		$this->db->insert('rooms', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('rooms');
	}
}
