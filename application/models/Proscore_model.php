<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proscore_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getDospem1($id)
	{
		$this->db->select('*, pro_register.id as pro_id, pro_nilai.id as nilai_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->join('pro_nilai','pro_register.id = pro_nilai.pro_register_id','inner');
		$this->db->where('pro_nilai.as', 'dospem-1');
		$this->db->where('title.dospem_1_id', $id);
		$this->db->where('pro_register.status', 'Diterima');
		$this->db->order_by('pro_register.id','desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getDospem2($id)
	{
		$this->db->select('*, pro_register.id as pro_id, pro_nilai.id as nilai_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->join('pro_nilai', 'pro_register.id = pro_nilai.pro_register_id', 'inner');
		$this->db->where('pro_nilai.as', 'dospem-2');
		$this->db->where('title.dospem_2_id', $id);
		$this->db->where('pro_register.status', 'Diterima');
		$this->db->order_by('pro_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getDosuji1($id)
	{
		$this->db->select('*, pro_register.id as pro_id, pro_nilai.id as nilai_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->join('pro_nilai', 'pro_register.id = pro_nilai.pro_register_id', 'inner');
		$this->db->where('pro_nilai.as', 'dosuji-1');
		$this->db->where('title.dosuji_1_id', $id);
		$this->db->where('pro_register.status', 'Diterima');
		$this->db->order_by('pro_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getDosuji2($id)
	{
		$this->db->select('*, pro_register.id as pro_id, pro_nilai.id as nilai_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->join('pro_nilai', 'pro_register.id = pro_nilai.pro_register_id', 'inner');
		$this->db->where('pro_nilai.as', 'dosuji-2');
		$this->db->where('title.dosuji_2_id', $id);
		$this->db->where('pro_register.status', 'Diterima');
		$this->db->order_by('pro_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getUjian($id)
	{
		$this->db->select('*, pro_register.id as pro_id, pro_nilai.id as nilai_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->join('pro_nilai', 'pro_register.id = pro_nilai.pro_register_id', 'inner');
		$this->db->where('pro_nilai.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function insertNilai($id,$data)
	{
		$this->db->where('id', $id);
		$this->db->update('pro_nilai', $data);
	}

	public function getNilai($id)
	{
		$this->db->select('*, pro_register.id as pro_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('title.mahasiswa', $id);
		$this->db->where('pro_register.status','diterima');
		$this->db->order_by('pro_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getNilaiAll()
	{
		$this->db->select('*, pro_register.id as pro_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('pro_register.status', 'diterima');
		$this->db->order_by('pro_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getNilaiData($id)
	{
		$this->db->select('*, pro_register.id as pro_id');
		$this->db->from('pro_register');
		$this->db->join('title', 'pro_register.title_id = title.id', 'inner');
		$this->db->where('pro_register.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getNilaiDospem1($id,$dosen)
	{
		$this->db->select('*');
		$this->db->from('pro_nilai');
		$this->db->where('pro_register_id', $id);
		$this->db->where('dosen_id', $dosen);
		$this->db->where('as','dospem-1');
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->row();
	}

	public function getNilaiDospem2($id, $dosen)
	{
		$this->db->select('*');
		$this->db->from('pro_nilai');
		$this->db->where('pro_register_id', $id);
		$this->db->where('dosen_id', $dosen);
		$this->db->where('as', 'dospem-2');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	public function getNilaiDosuji1($id, $dosen)
	{
		$this->db->select('*');
		$this->db->from('pro_nilai');
		$this->db->where('pro_register_id', $id);
		$this->db->where('dosen_id', $dosen);
		$this->db->where('as', 'dosuji-1');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	public function getNilaiDosuji2($id, $dosen)
	{
		$this->db->select('*');
		$this->db->from('pro_nilai');
		$this->db->where('pro_register_id', $id);
		$this->db->where('dosen_id', $dosen);
		$this->db->where('as', 'dosuji-2');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	public function insertNilaiTitle($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('title', $data);
	}

	public function insertNilaiRegister($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('pro_register', $data);
	}

	public function update_nilai($pro_id, $nilai)
	{
		$data = array('nilai' => $nilai);
		$this->db->where('id', $pro_id);
		return $this->db->update('pro_register', $data);
	}
}
