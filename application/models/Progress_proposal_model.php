<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Progress_proposal_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Load the 'user2' database
    }

    public function get_pembimbing($user_id)
    {
        // First subquery for Dosen Pembimbing 1
        $this->db->select("u1.id, u1.nama, 'Dosen Pembimbing 1' AS role, title.id as title_id");
        $this->db->from('title');
        $this->db->join('users u1', 'title.dospem_1_id = u1.id');
        $this->db->where('title.mahasiswa', $user_id);
        $this->db->where('title.status', 'Diterima');
        $subquery1 = $this->db->get_compiled_select();

        // Second subquery for Dosen Pembimbing 2
        $this->db->select("u2.id, u2.nama, 'Dosen Pembimbing 2' AS role, title.id as title_id");
        $this->db->from('title');
        $this->db->join('users u2', 'title.dospem_2_id = u2.id');
        $this->db->where('title.mahasiswa', $user_id);
        $this->db->where('title.status', 'Diterima');
        $subquery2 = $this->db->get_compiled_select();

        // Combine the subqueries using UNION ALL
        $sql = "($subquery1) UNION ALL ($subquery2) ORDER BY title_id DESC LIMIT 2";

        // Execute the combined query
        $query = $this->db->query($sql);

        // Return the result
        return $query->result();
    }

    public function get_judul($user_id)
    {
        $this->db->select('title.id, title.judul, title.dospem_1_id, title.dospem_2_id');
        $this->db->from('title');
        $this->db->where('mahasiswa', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function is_has_accepted_title($user_id)
    {
        $this->db->select('title.id, title.judul');
        $this->db->from('title');
        $this->db->where('mahasiswa', $user_id);
        $this->db->where('status', 'Diterima');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_progress($data)
    {
        return $this->db->insert('pro_progress', $data);
    }

    public function get_proposal_data()
    {
        $this->db->select('pro_progress.id, pro_progress.tanggal, title.judul, users.nama as nama_pembimbing, pro_progress.bab, pro_progress.pembahasan, pro_progress.bukti, pro_progress.status');
        $this->db->from('pro_progress');
        $this->db->join('title', 'pro_progress.judul_id = title.id', 'inner');
        $this->db->join('users', 'pro_progress.pembimbing = users.id', 'inner');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_proposal_data_by_user_id($user_id)
    {
        $this->db->select('pro_progress.id, pro_progress.tanggal, title.judul, users.nama as nama_pembimbing, pro_progress.bab, pro_progress.pembahasan, pro_progress.bukti, pro_progress.status');
        $this->db->from('pro_progress');
        $this->db->join('title', 'pro_progress.judul_id = title.id', 'inner');
        $this->db->join('users', 'pro_progress.pembimbing = users.id', 'inner');
        $this->db->where('title.mahasiswa', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function download_progress_proposal_dospem($user_id, $dosen_id)
    {
        $this->db->select('pro_progress.id, pro_progress.tanggal, title.judul, pembimbing.nama as nama_pembimbing, pro_progress.bab, pro_progress.pembahasan, pro_progress.bukti, pro_progress.status, mahasiswa.nama as nama_mahasiswa, mahasiswa.npm as npm_mahasiswa');
        $this->db->from('pro_progress');
        $this->db->join('title', 'pro_progress.judul_id = title.id', 'inner');
        $this->db->join('users pembimbing', 'pro_progress.pembimbing = pembimbing.id', 'inner');
        $this->db->join('users mahasiswa', 'title.mahasiswa = mahasiswa.id', 'inner');
        $this->db->where('title.mahasiswa', $user_id);
        $this->db->where('pro_progress.pembimbing', $dosen_id);

        // Menjalankan query menggunakan metode CI3
        $query = $this->db->get();
        return $query->result();
    }


    public function get_proposal_data_by_mahasiswa($id, $dosen_id)
    {
        $this->db->select('pro_progress.id, pro_progress.tanggal, title.judul, users.nama as nama_pembimbing, pro_progress.bab, pro_progress.pembahasan, pro_progress.bukti, pro_progress.status');
        $this->db->from('pro_progress');
        $this->db->join('title', 'pro_progress.judul_id = title.id', 'inner');
        $this->db->join('users', 'pro_progress.pembimbing = users.id', 'inner');
        $this->db->where('title.mahasiswa', $id);
        $this->db->where('pro_progress.pembimbing', $dosen_id); // Filter by supervisor
        $query = $this->db->get();
        return $query->result();
    }

    public function get_proposal_data_by_mahasiswa_foradmin($mahasiswa_id, $dosen_id = null)
    {
        $this->db->select('pro_progress.id, pro_progress.tanggal, title.judul, users.nama as nama_pembimbing, pro_progress.bab, pro_progress.pembahasan, pro_progress.bukti, pro_progress.status');
        $this->db->from('pro_progress');
        $this->db->join('title', 'pro_progress.judul_id = title.id', 'inner');
        $this->db->join('users', 'pro_progress.pembimbing = users.id', 'inner');
        $this->db->where('title.mahasiswa', $mahasiswa_id); // Filter by mahasiswa

        if (!is_null($dosen_id)) {
            $this->db->where('pro_progress.pembimbing', $dosen_id); // Optionally filter by dosen
        }

        $query = $this->db->get();
        return $query->result();
    }



    public function get_bukti_by_id($id)
    {
        $this->db->select('bukti');
        $this->db->from('pro_progress');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }


    //kolom status dan aksi
    public function get_all_proposals()
    {
        $this->db->select('*');
        $this->db->from('pro_progress');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_proposal_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('pro_progress');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function update_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update('pro_progress', array('status' => $status));
        return $this->db->affected_rows();
    }
    //end kolom 

    // public function get_mahasiswa_for_dosen($pembimbing_id)
    // {
    //     $this->db->select('u.id, u.nama, t.judul');
    //     $this->db->from('pro_progress pp');
    //     $this->db->join('title t', 'pp.judul_id = t.id');
    //     $this->db->join('users u', 't.mahasiswa = u.id');
    //     $this->db->where('pp.pembimbing', $pembimbing_id);
    //     $this->db->group_by('u.nama');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    public function get_mahasiswa_for_dosen($pembimbing_id)
    {
        $current_year = date('Y');
        $target_year = $current_year - 4;

        $subquery = $this->db->select('MAX(id) as id')
            ->from('title')
            ->where('status', 'Diterima')
            ->group_start()
            ->where('dospem_1_id', $pembimbing_id)
            ->or_where('dospem_2_id', $pembimbing_id)
            ->group_end()
            ->group_by('mahasiswa')
            ->get_compiled_select();

        $this->db->select('
        u.id, 
        u.npm, 
        u.nama, 
        t.judul,
        IFNULL(
            CASE 
                WHEN t.status = "Diterima" THEN "Judul Diterima"
                WHEN t.status = "Ditolak" THEN "Pengajuan Judul"
                WHEN t.status = "Sedang diproses" THEN "Pengajuan Judul"
                ELSE "Pengajuan Judul"
            END,
            "-"
        ) AS status_judul,
        IFNULL(
            CASE 
                WHEN pp.id IS NOT NULL THEN "Bimbingan Proposal"
                ELSE NULL
            END,
            "-"
        ) AS status_bimbingan_proposal,
        IFNULL(
            CASE 
                WHEN t.status_ujian_proposal = "Belum terdaftar" THEN "Belum daftar"
                WHEN t.status_ujian_proposal = "Terdaftar" THEN "Ujian Proposal"
                WHEN t.status_ujian_proposal = "Lulus" THEN "Selesai"
                WHEN t.status_ujian_proposal = "Lulus ubah judul" THEN "Lulus dengan revisi"
                WHEN t.status_ujian_proposal = "Tidak lulus" THEN "Tidak lulus"
                ELSE NULL
            END,
            "-"
        ) AS status_ujian_proposal,
        IFNULL(
            CASE 
                WHEN sp.id IS NOT NULL THEN "Bimbingan Skripsi"
                ELSE NULL
            END,
            "-"
        ) AS status_bimbingan_skripsi,
        IFNULL(
            CASE 
                WHEN t.status_ujian_skripsi = "Belum terdaftar" THEN "Belum daftar"
                WHEN t.status_ujian_skripsi = "Terdaftar" THEN "Ujian skripsi"
                WHEN t.status_ujian_skripsi = "Lulus" THEN "Selesai"
                WHEN t.status_ujian_skripsi = "Tidak lulus" THEN "Tidak lulus"
                ELSE NULL
            END,
            "-"
        ) AS status_ujian_skripsi,
        IFNULL(
            CASE 
                WHEN spc.id IS NOT NULL THEN "Selesai"
                ELSE NULL
            END,
            "-"
        ) AS status_skripsi_selesai
    ');

        $this->db->from('title t');
        $this->db->join('users u', 't.mahasiswa = u.id');
        $this->db->join('pro_progress pp', 'pp.judul_id = t.id', 'left');
        $this->db->join('skp_progress sp', 'sp.judul_id = t.id', 'left');
        $this->db->join('skp_pasca spc', 'spc.title_id = t.id', 'left');
        $this->db->where('t.status', 'Diterima');
        $this->db->where("t.id IN ($subquery)", NULL, FALSE);
        $this->db->where('u.angkatan', $target_year); // Filter by the latest batch year
        $this->db->order_by('t.id', 'DESC'); // Order by ID if there's no created_at column
        $this->db->distinct();
        $query = $this->db->get();

        return $query->result();
    }


    public function get_mahasiswa_for_koordinator()
    {
        $this->db->select('u.id, u.nama, t.judul');
        $this->db->from('pro_progress pp');
        $this->db->join('title t', 'pp.judul_id = t.id');
        $this->db->join('users u', 't.mahasiswa = u.id');
        $this->db->group_by('u.nama');
        $query = $this->db->get();
        return $query->result();
    }


    public function delete_progress($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pro_progress');
        return $this->db->affected_rows();
    }

    public function get_proposal_data_from_dospem_by_mahasiswa($id)
    {
        $this->db->select('pro_progress.id, pro_progress.tanggal, title.judul, users.nama as nama_pembimbing, pro_progress.bab, pro_progress.pembahasan, pro_progress.bukti, pro_progress.status');
        $this->db->from('pro_progress');
        $this->db->join('title', 'pro_progress.judul_id = title.id', 'inner');
        $this->db->join('users', 'pro_progress.pembimbing = users.id', 'inner');
        $this->db->where('title.mahasiswa', $id);
        $query = $this->db->get();
        return $query->result();
    }

    //revisi
    public function get_filtered_data($angkatan = null, $npm = null, $status_terakhir = null, $dospem_1_nama = null, $dospem_2_nama = null, $role = 'mahasiswa')
    {
        $this->db->distinct();
        $this->db->select('
        u.nama, 
        u.npm, 
        IFNULL(
            CASE 
                WHEN t.status = "Diterima" THEN "Judul Diterima"
                WHEN t.status = "Ditolak" THEN "Pengajuan Judul"
                WHEN t.status = "Sedang diproses" THEN "Pengajuan Judul"
                ELSE "Pengajuan Judul"
            END,
            "-"
        ) AS status_judul,
        IFNULL(
            CASE 
                WHEN pp.id IS NOT NULL THEN "Bimbingan Proposal"
                ELSE NULL
            END,
            "-"
        ) AS status_bimbingan_proposal,
        IFNULL(
            CASE 
                WHEN t.status_ujian_proposal = "Belum terdaftar" THEN "Belum daftar"
                WHEN t.status_ujian_proposal = "Terdaftar" THEN "Ujian Proposal"
                WHEN t.status_ujian_proposal = "Lulus" THEN "Selesai"
                WHEN t.status_ujian_proposal = "Lulus ubah judul" THEN "Lulus dengan revisi"
                WHEN t.status_ujian_proposal = "Tidak lulus" THEN "Tidak lulus"
                ELSE NULL
            END,
            "-"
        ) AS status_ujian_proposal,
        IFNULL(
            CASE 
                WHEN sp.id IS NOT NULL THEN "Bimbingan Skripsi"
                ELSE NULL
            END,
            "-"
        ) AS status_bimbingan_skripsi,
        IFNULL(
            CASE 
                 WHEN t.status_ujian_skripsi = "Belum terdaftar" THEN "Belum daftar"
                WHEN t.status_ujian_skripsi = "Terdaftar" THEN "Ujian skripsi"
                WHEN t.status_ujian_skripsi = "Lulus" THEN "Selesai"
                WHEN t.status_ujian_skripsi = "Tidak lulus" THEN "Tidak lulus"
                ELSE NULL
            END,
            "-"
        ) AS status_ujian_skripsi,
        IFNULL(
            CASE 
                WHEN spc.id IS NOT NULL THEN "Selesai"
                ELSE NULL
            END,
            "-"
        ) AS status_skripsi_selesai,
        d1.nama AS dospem_1_nama,
        d2.nama AS dospem_2_nama
    ');

        $this->db->from('users u');
        $this->db->join('title t', 'u.id = t.mahasiswa', 'left');
        $this->db->join('pro_progress pp', 'pp.judul_id = t.id', 'left');
        $this->db->join('skp_progress sp', 'sp.judul_id = t.id', 'left');
        $this->db->join('skp_pasca spc', 'spc.title_id = t.id', 'left');
        $this->db->join('users d1', 't.dospem_1_id = d1.id', 'left');
        $this->db->join('users d2', 't.dospem_2_id = d2.id', 'left');

        if ($role == 'mahasiswa') {
            $this->db->where('u.group_id', 1);

            if ($angkatan) {
                $this->db->where('u.angkatan', $angkatan);
            }
            if ($npm) {
                $this->db->where('u.npm', $npm);
            }
            if ($status_terakhir) {
                $this->db->group_start(); // Mulai grup untuk or_having
                $this->db->having('status_judul', $status_terakhir);
                $this->db->or_having('status_bimbingan_proposal', $status_terakhir);
                $this->db->or_having('status_ujian_proposal', $status_terakhir);
                $this->db->or_having('status_bimbingan_skripsi', $status_terakhir);
                $this->db->or_having('status_ujian_skripsi', $status_terakhir);
                $this->db->or_having('status_skripsi_selesai', $status_terakhir);
                $this->db->group_end(); // Akhiri grup untuk or_having
            }
            if ($dospem_1_nama) {
                $this->db->like('d1.nama', $dospem_1_nama);
            }
            if ($dospem_2_nama) {
                $this->db->like('d2.nama', $dospem_2_nama);
            }
        } elseif ($role == 'dosen') {
            $this->db->where_in('u.group_id', [2, 3]);
            $this->db->select('u.nama');
        }

        $this->db->order_by('u.nama', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
}
