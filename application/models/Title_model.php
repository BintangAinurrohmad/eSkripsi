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

    public function accTitle($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('title', $data);
    }

    public function getTitle()
    {
        $this->db->select('title.*, users.nama as nama_mahasiswa');
        $this->db->join('users', 'title.mahasiswa = users.id', 'left');
        $this->db->order_by('title.id', 'DESC');
        $query = $this->db->get('title');
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

    public function search($keyword)
    {
        $this->db->select('title.*, users.nama as nama_mahasiswa');
        $this->db->join('users', 'title.mahasiswa = users.id', 'left');
        $this->db->like('judul', $keyword);
        $this->db->or_like('mahasiswa_nama', $keyword);
        $this->db->order_by('title.id', 'DESC');
        $query = $this->db->get('title');
        return $query->result();
    }

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
}
