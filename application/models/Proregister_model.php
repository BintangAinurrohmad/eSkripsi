<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proregister_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getProposal()
	{
		$this->db->select('*, pro_register.status as pro_status, pro_register.status_dospem_1 as pro_status_dospem_1, pro_register.status_dospem_2 as pro_status_dospem_2');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$query = $this->db->get();
		return $query->result();
	}

	public function getMyProposal($user_id)
	{
		$this->db->select('*, pro_register.id as pro_id, pro_register.status as pro_status, pro_register.status_dospem_1 as pro_status_dospem_1, pro_register.status_dospem_2 as pro_status_dospem_2');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('title.mahasiswa', $user_id);
		$this->db->order_by('pro_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getMyTitle($user_id)
	{
		$this->db->where('mahasiswa', $user_id);
		$this->db->where('status', 'Diterima');
		$this->db->where('status_ujian_proposal', 'Belum terdaftar');
		$this->db->order_by('id', 'DESC'); // Mengurutkan berdasarkan kolom id dengan urutan menurun
		$this->db->limit(1); // Mengambil 1 baris terbaru
		$query = $this->db->get('title');
		return $query->row(); // Mengembalikan 1 baris sebagai array
	}

	public function addProposal($data)
	{
		$this->db->insert('pro_register', $data);
	}

	public function getProposalDospem1($id)
	{
		$this->db->select('*, pro_register.status as pro_status, pro_register.status_dospem_1 as pro_status_dospem_1, pro_register.status_dospem_2 as pro_status_dospem_2, pro_register.id as pro_id, title.id as title_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('title.dospem_1_id', $id);
		$this->db->where('title.status_ujian_proposal', 'Terdaftar');
		$this->db->order_by('pro_register.id', 'desc');
		$query = $this->db->get('');
		return $query->result();
	}

	public function getProposalDospem2($id)
	{
		$this->db->select('*, pro_register.status as pro_status, pro_register.status_dospem_1 as pro_status_dospem_1, pro_register.status_dospem_2 as pro_status_dospem_2, pro_register.id as pro_id, title.id as title_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('title.dospem_2_id', $id);
		$this->db->where('title.status_ujian_proposal', 'Terdaftar');
		$this->db->order_by('pro_register.id', 'desc');
		$query = $this->db->get('');
		return $query->result();
	}

	public function getProposalKoo()
	{
		$this->db->select('*, pro_register.status as pro_status, pro_register.status_dospem_1 as pro_status_dospem_1, pro_register.status_dospem_2 as pro_status_dospem_2, pro_register.id as pro_id, title.id as title_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('pro_register.status', 'Sedang diproses');
		$this->db->where('title.status_ujian_proposal', 'Terdaftar');
		$this->db->order_by('pro_register.id', 'desc');
		$query = $this->db->get('');
		return $query->result();
	}

	public function getThisProposal($pro_id)
	{
		$this->db->select('*, pro_register.status as pro_status, pro_register.status_dospem_1 as pro_status_dospem_1, pro_register.status_dospem_2 as pro_status_dospem_2, pro_register.id as pro_id, title.id as title_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('pro_register.id', $pro_id);
		$this->db->order_by('pro_register.id', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	//bintang
	public function accProposal($id, $data)
	{
		// Get the title_id from the pro_register table
		$this->db->select('title_id');
		$this->db->where('id', $id);
		$title_id = $this->db->get('pro_register')->row()->title_id;

		// Get the mahasiswa_id from the title table
		$this->db->select('mahasiswa');
		$this->db->where('id', $title_id);
		$mahasiswa_id = $this->db->get('title')->row()->mahasiswa;

		// Update the pro_register table
		$this->db->where('id', $id);
		$this->db->update('pro_register', $data);

		// You can now use the $mahasiswa_id variable for further processing
	}

	public function getRooms()
	{
		return $this->db->get('rooms')->result_array();
	}

	public function getDosen()
	{
		$this->db->where('group_id', '2');
		$this->db->or_where('group_id', '3');
		$query = $this->db->get('users');
		return $query->result_array();
	}

	public function setDosuji($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('title', $data);
	}

	public function setTitle($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('title', $data);
	}

	public function addUjian($data)
	{
		$this->db->insert('pro_nilai', $data);
	}
}
