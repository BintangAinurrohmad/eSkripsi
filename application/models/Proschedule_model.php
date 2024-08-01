<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proschedule_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	//jadwal koordinator (dsn x mhs)
	public function getAll()
	{
		$this->db->select('*, pro_register.id as pro_id, pro_register.status as pro_status, pro_register.status_dospem_1 as pro_status_dospem_1, pro_register.status_dospem_2 as pro_status_dospem_2, title.id as title_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('pro_register.status', 'Diterima');
		$this->db->order_by('tanggal', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	//jadwal untuk mhs
	public function getMhs($user_id)
	{
		$this->db->select('*, pro_register.id as pro_id, pro_register.status as pro_status, pro_register.status_dospem_1 as pro_status_dospem_1, pro_register.status_dospem_2 as pro_status_dospem_2');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('title.mahasiswa', $user_id);
		$this->db->where('pro_register.status', 'Diterima');
		$this->db->order_by('tanggal', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	//jadwal untuk dosen
	public function getDsn($user_id)
	{
		$this->db->select('*, pro_register.id as pro_id, pro_register.status as pro_status, pro_register.status_dospem_1 as pro_status_dospem_1, pro_register.status_dospem_2 as pro_status_dospem_2');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('pro_register.status', 'Diterima');
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
		$this->db->update('pro_register', $data);
		return $this->db->affected_rows();
	}

	public function getRooms()
	{
		return $this->db->get('rooms')->result_array();
	}

	public function get_berita_acara($id)
	{
		$this->db->select('*, pro_register.id as pro_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('pro_register.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

}
