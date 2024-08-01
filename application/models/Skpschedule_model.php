<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Skpschedule_model extends CI_Model
{
	private $table = 'users';

	public function __construct()
	{
		parent::__construct();
	}

	public function getAll()
	{
		$this->db->select('*, skp_register.id as skp_id, skp_register.status as skp_status, skp_register.status_dospem_1 as skp_status_dospem_1, skp_register.status_dospem_2 as skp_status_dospem_2, title.id as title_id');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->where('skp_register.status', 'Diterima');
		$this->db->order_by('tanggal', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getMhs($user_id)
	{
		$this->db->select('*, skp_register.id as skp_id, skp_register.status as skp_status, skp_register.status_dospem_1 as skp_status_dospem_1, skp_register.status_dospem_2 as skp_status_dospem_2');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->where('title.mahasiswa', $user_id);
		$this->db->where('skp_register.status', 'Diterima');
		$this->db->order_by('tanggal', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getDsn($user_id)
	{
		$this->db->select('*, skp_register.id as skp_id, skp_register.status as skp_status, skp_register.status_dospem_1 as skp_status_dospem_1, skp_register.status_dospem_2 as skp_status_dospem_2');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->where('skp_register.status', 'Diterima');
		$this->db->order_by('tanggal', 'DESC');
		$this->db->group_start();
		$this->db->or_where('title.dospem_1_id', $user_id);
		$this->db->or_where('title.dospem_2_id', $user_id);
		$this->db->or_where('title.dosuji_1_id', $user_id);
		$this->db->or_where('title.dosuji_2_id', $user_id);
		$this->db->group_end();
		$query = $this->db->get();
		return $query->result();
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('skp_register', $data);
		return $this->db->affected_rows();
	}

	public function getRooms()
	{
		return $this->db->get('rooms')->result_array();
	}
}
