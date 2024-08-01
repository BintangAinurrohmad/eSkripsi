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
		$query = $this->db->get('pengumuman');
		return $query->result();
	}

	public function create($data)
	{
		$this->db->insert('pengumuman', $data);
	}
}
