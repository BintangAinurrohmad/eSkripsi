<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Skppasca_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get_title($user_id)
	{
		$this->db->select('*, title.id as judul_id');
		$this->db->from('title');
		$this->db->join('skp_register', 'skp_register.title_id = title.id', 'inner');
		$this->db->where('title.status_ujian_skripsi', 'Selesai');
		$this->db->where('title.mahasiswa', $user_id);
		$this->db->order_by('title.tanggal_pengajuan', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->row();
	}

	public function insert($data)
	{
		return $this->db->insert('skp_pasca', $data);
	}

	public function cek($title)
	{
		$this->db->select('*');
		$this->db->from('skp_pasca');
		$this->db->join('title', 'skp_pasca.title_id = title.id', 'inner');
		$this->db->where('title.id', $title);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_all()
	{
		$this->db->select('*, skp_pasca.id as pasca_id');
		$this->db->from('skp_pasca');
		$this->db->join('title', 'skp_pasca.title_id = title.id', 'inner');
		$this->db->order_by('skp_pasca.id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
}
