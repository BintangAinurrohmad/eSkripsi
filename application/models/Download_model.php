<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Download_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'downloads';
	}

	public function get()
	{
		$query = $this->db->get($this->table);
		return $query->result();
	}

	public function insert_download($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_download_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get($this->table);
		return $query->row();
	}

	public function delete_download($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

}
