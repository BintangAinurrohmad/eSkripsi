<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Progress_mhs_model extends CI_Model
{
    public function get_all_mahasiswa($angkatan = null, $npm = null, $status_terakhir = null, $dospem_1_nama = null, $dospem_2_nama = null)
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
                WHEN t.status_ujian_proposal = "Selesai" THEN "Ujian Proposal"
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
                WHEN t.status_ujian_skripsi = "Selesai" THEN "Ujian Skripsi"
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

        $this->db->where('u.group_id', 1);

        if ($angkatan) {
            $this->db->where('u.angkatan', $angkatan);
        }
        if ($npm) {
            $this->db->where('u.npm', $npm);
        }
        if ($status_terakhir) {
            $this->db->having('status_judul', $status_terakhir);
            $this->db->or_having('status_bimbingan_proposal', $status_terakhir);
            $this->db->or_having('status_ujian_proposal', $status_terakhir);
            $this->db->or_having('status_bimbingan_skripsi', $status_terakhir);
            $this->db->or_having('status_ujian_skripsi', $status_terakhir);
            $this->db->or_having('status_skripsi_selesai', $status_terakhir);
        }
        if ($dospem_1_nama) {
            $this->db->like('d1.nama', $dospem_1_nama);
        }
        if ($dospem_2_nama) {
            $this->db->like('d2.nama', $dospem_2_nama);
        }

        $this->db->order_by('u.nama', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
}