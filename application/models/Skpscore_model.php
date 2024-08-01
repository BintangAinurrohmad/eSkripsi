<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Skpscore_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getDospem1($id)
	{
		$this->db->select('*, skp_register.id as skp_id, skp_nilai.id as nilai_id');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->join('skp_nilai', 'skp_register.id = skp_nilai.skp_register_id', 'inner');
		$this->db->where('skp_nilai.as', 'dospem-1');
		$this->db->where('title.dospem_1_id', $id);
		$this->db->where('skp_register.status', 'Diterima');
		$this->db->order_by('skp_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getDospem2($id)
	{
		$this->db->select('*, skp_register.id as skp_id, skp_nilai.id as nilai_id');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->join('skp_nilai', 'skp_register.id = skp_nilai.skp_register_id', 'inner');
		$this->db->where('skp_nilai.as', 'dospem-2');
		$this->db->where('title.dospem_2_id', $id);
		$this->db->where('skp_register.status', 'Diterima');
		$this->db->order_by('skp_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getDosuji1($id)
	{
		$this->db->select('*, skp_register.id as skp_id, skp_nilai.id as nilai_id');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->join('skp_nilai', 'skp_register.id = skp_nilai.skp_register_id', 'inner');
		$this->db->where('skp_nilai.as', 'dosuji-1');
		$this->db->where('title.dosuji_1_id', $id);
		$this->db->where('skp_register.status', 'Diterima');
		$this->db->order_by('skp_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getDosuji2($id)
	{
		$this->db->select('*, skp_register.id as skp_id, skp_nilai.id as nilai_id');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->join('skp_nilai', 'skp_register.id = skp_nilai.skp_register_id', 'inner');
		$this->db->where('skp_nilai.as', 'dosuji-2');
		$this->db->where('title.dosuji_2_id', $id);
		$this->db->where('skp_register.status', 'Diterima');
		$this->db->order_by('skp_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getUjian($id)
	{
		$this->db->select('*, skp_register.id as skp_id, skp_nilai.id as nilai_id');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->join('skp_nilai', 'skp_register.id = skp_nilai.skp_register_id', 'inner');
		$this->db->where('skp_nilai.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function insertNilai($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('skp_nilai', $data);
	}

	public function getNilai($id)
	{
		$this->db->select('*, skp_register.id as skp_id');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->where('title.mahasiswa', $id);
		$this->db->where('skp_register.status', 'diterima');
		$this->db->order_by('skp_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getNilaiAll()
	{
		$this->db->select('*, skp_register.id as skp_id');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->where('skp_register.status', 'diterima');
		$this->db->order_by('skp_register.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getNilaiData($id)
	{
		$this->db->select('*, skp_register.id as skp_id');
		$this->db->from('skp_register');
		$this->db->join('title', 'skp_register.title_id = title.id', 'inner');
		$this->db->where('skp_register.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getNilaiDospem1($id, $dosen)
	{
		$this->db->select('*');
		$this->db->from('skp_nilai');
		$this->db->where('skp_register_id', $id);
		$this->db->where('dosen_id', $dosen);
		$this->db->where('as', 'dospem-1');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	public function getNilaiDospem2($id, $dosen)
	{
		$this->db->select('*');
		$this->db->from('skp_nilai');
		$this->db->where('skp_register_id', $id);
		$this->db->where('dosen_id', $dosen);
		$this->db->where('as', 'dospem-2');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	public function getNilaiDosuji1($id, $dosen)
	{
		$this->db->select('*');
		$this->db->from('skp_nilai');
		$this->db->where('skp_register_id', $id);
		$this->db->where('dosen_id', $dosen);
		$this->db->where('as', 'dosuji-1');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	public function getNilaiDosuji2($id, $dosen)
	{
		$this->db->select('*');
		$this->db->from('skp_nilai');
		$this->db->where('skp_register_id', $id);
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
		$this->db->update('skp_register', $data);
	}

	public function update_nilai($skp_id, $nilai)
	{
		$data = array('nilai' => $nilai);
		$this->db->where('id', $skp_id);
		return $this->db->update('skp_register', $data);
	}
}
