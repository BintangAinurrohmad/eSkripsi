<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Title_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getResearchArea()
	{
		return $this->db->get('research_area')->result_array();
	}

	public function getDosen()
	{
		$current_year = date('Y');
		$target_year = $current_year - 4;

		$this->db->select('u.id, u.nama, COUNT(m.id) AS jumlah_mahasiswa');
		$this->db->from('users u');
		$this->db->join('title t', '(u.id = t.dospem_1_id OR u.id = t.dospem_2_id) AND t.status = "Diterima"', 'left');
		$this->db->join('users m', 'm.id = t.mahasiswa AND m.group_id = 1 AND m.angkatan = ' . $target_year, 'left');
		$this->db->where('(u.group_id = 2 OR u.group_id = 3)');
		$this->db->group_by('u.id, u.nama');
		$this->db->order_by('jumlah_mahasiswa', 'DESC');

		$query = $this->db->get();

		$dosen_mahasiswa = array();
		foreach ($query->result() as $row) {
			$dosen_mahasiswa[] = array(
				'id_dosen' => $row->id,
				'nama_dosen' => $row->nama,
				'jumlah_mahasiswa' => $row->jumlah_mahasiswa
			);
		}

		return $dosen_mahasiswa;
	}


	public function addTitle($data)
	{
		$this->db->insert('title', $data);
		return $this->db->insert_id();
	}

	public function addSkripsi($data)
	{
		$this->db->insert('skripsi_lama', $data);
		return $this->db->insert_id();
	}

	public function accTitle($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('title', $data);
	}

	public function getTitle()
	{
		$this->db->select('title.judul as judul, title.bidang_id as bidang_id, users.npm as npm, users.nama as nama_mahasiswa, title.dospem_1_id as dospem_1_id, title.status_dospem_1 as status_dospem_1, title.dospem_2_id as dospem_2_id, title.status_dospem_2 as status_dospem_2, title.status as status');
		$this->db->from('title');
		$this->db->join('users', 'title.mahasiswa = users.id', 'left');
		$query1 = $this->db->get_compiled_select();

		$this->db->select('judul, bidang_id, npm, nama_mahasiswa, dospem_1_id, status_dospem_1, dospem_2_id, status_dospem_2, status');
		$this->db->from('skripsi_lama');
		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . " UNION " . $query2);

		return $query->result();
	}

	public function getSkripsi()
	{
		$this->db->select('title.judul as judul, title.bidang_id as bidang_id, users.npm as npm, users.nama as nama_mahasiswa, title.dospem_1_id as dospem_1_id, title.status_dospem_1 as status_dospem_1, title.dospem_2_id as dospem_2_id, title.status_dospem_2 as status_dospem_2, title.status as status');
		$this->db->from('title');
		$this->db->join('users', 'title.mahasiswa = users.id', 'left');
		$this->db->where('title.status', 'Diterima');
		$query1 = $this->db->get_compiled_select();

		$this->db->select('judul, bidang_id, npm, nama_mahasiswa, dospem_1_id, status_dospem_1, dospem_2_id, status_dospem_2, status');
		$this->db->from('skripsi_lama');
		$query2 = $this->db->get_compiled_select();

		$query = $this->db->query($query1 . " UNION " . $query2);

		return $query->result();
	}

	public function getAllTitleDosen($user_id)
	{
		$this->db->select('title.*, users.nama as nama_mahasiswa');
		$this->db->join('users', 'title.mahasiswa = users.id', 'left');
		$this->db->where('dospem_1_id', $user_id);
		$this->db->or_where('dospem_2_id', $user_id);
		$this->db->order_by('title.id', 'DESC');
		$query = $this->db->get('title');
		return $query->result();
	}

	public function getMyTitle($user_id)
	{
		$this->db->select('title.*, users.nama as nama_mahasiswa');
		$this->db->join('users', 'title.mahasiswa = users.id', 'left');
		$this->db->where('users.id', $user_id);
		$this->db->order_by('title.id', 'DESC');
		$query = $this->db->get('title');
		return $query->result();
	}
	// bintang
	public function getMyTitleById($id)
	{
		$this->db->select('title.*');
		$this->db->where('id', $id);
		$query = $this->db->get('title');
		return $query->result();
	}

	// bintang
	public function getMyLastAccTitle($user_id)
	{
		$this->db->select('title.*, users.nama as nama_mahasiswa');
		$this->db->join('users', 'title.mahasiswa = users.id', 'left');
		$this->db->where('users.id', $user_id);
		$this->db->where('title.status', 'Diterima');
		$this->db->order_by('title.id', 'DESC');
		$query = $this->db->get('title');
		return $query->first_row();
	}

	public function getTitleDospem1($id)
	{
		$this->db->select('title.*');
		$this->db->where('dospem_1_id', $id);
		$this->db->where('status_dospem_1', 'Sedang diproses');
		$this->db->order_by('title.id', 'DESC');
		$query = $this->db->get('title');
		return $query->result();
	}

	public function getTitleDospem2($id)
	{
		$this->db->select('title.*');
		$this->db->where('dospem_2_id', $id);
		$this->db->where('status_dospem_2', 'Sedang diproses');
		$this->db->order_by('title.id', 'DESC');
		$query = $this->db->get('title');
		return $query->result();
	}

	public function getTitleKo()
	{
		$this->db->select('title.*');
		$this->db->where('status', 'Sedang diproses');
		$this->db->order_by('title.id', 'DESC');
		$query = $this->db->get('title');
		return $query->result();
	}

	public function getTitleOnly()
	{
		$this->db->select('title.*, users.nama as nama_mahasiswa');
		$this->db->join('users', 'title.mahasiswa = users.id', 'left');
		$this->db->order_by('title.id', 'DESC');
		$query = $this->db->get('title');
		return $query->result();
	}

	// public function search($keyword)
	// {
	//     $this->db->select('title.*, users.nama as nama_mahasiswa');
	//     $this->db->join('users', 'title.mahasiswa = users.id', 'left');
	//     $this->db->like('judul', $keyword);
	//     $this->db->or_like('mahasiswa_nama', $keyword);
	//     $this->db->order_by('title.id', 'DESC');
	//     $query = $this->db->get('title');
	//     return $query->result();
	// }

	public function getThisTitle($title_id)
	{
		$this->db->select('*');
		$this->db->from('title');
		$this->db->where('id', $title_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function editTitle($title_id, $data)
	{
		$this->db->where('id', $title_id);
		$this->db->update('title', $data);
	}

	// public function getApprovedTitles()
	// {
	// 	$this->db->select('title.*, users.nama as nama_mahasiswa');
	// 	$this->db->join('users', 'title.mahasiswa = users.id', 'left');
	// 	$this->db->where('title.status', 'Diterima');
	// 	$query = $this->db->get('title');

	// 	return $query->result();
	// }

	public function getCombinedTitles()
	{
		// Mengambil data dari tabel `titles` dengan status "Diterima"
		$this->db->select('title.judul, users.nama as nama_mahasiswa');
		$this->db->from('title');
		$this->db->join('users', 'title.mahasiswa = users.id', 'left');
		$this->db->where('title.status', 'Diterima');
		$approved_titles = $this->db->get()->result_array();

		// Mengambil data dari tabel `titles_repository`
		$this->db->select('judul, nama_mahasiswa');
		$repository_titles = $this->db->get('skripsi_lama')->result_array();

		// Menggabungkan hasil dari kedua tabel
		$combined_titles = array_merge($approved_titles, $repository_titles);

		return $combined_titles;
	}
}
