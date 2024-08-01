<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ra_model extends CI_Model
{
	private $table = 'users';

	public function __construct()
	{
		parent::__construct();
	}

	public function get()
	{
		$query = $this->db->get('research_area');
		return $query->result();
	}

	public function create($data)
	{
		$this->db->insert('research_area', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('research_area');
	}
}
