<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    // public function get_pendaftaran_percentage()
    // {
    //     // Replace 'your_table_name' with the actual table name
    //     $query = $this->db->select('COUNT(*) AS total_pendaftar')
    //         ->from('users')
    //         ->get();
    //     $total_pendaftar = $query->row()->total_pendaftar;

    //     // You need to have a total number of records (e.g., from another table or calculated)
    //     // Replace 'total_records' with the actual total number
    //     $total_records = 100; // Example: 100 total records

    //     $percentage = ($total_pendaftar / $total_records) * 100;
    //     return round($percentage, 2); // Return the percentage rounded to two decimal places
    // }


    // // Similar functions for bimbingan and seminar percentages
    // public function get_bimbingan_percentage()
    // {
    //     $user_id = $this->session->userdata('user_id');
    //     $this->db->select('bab');
    //     $this->db->from('pro_progress');
    //     $this->db->join('title', 'pro_progress.judul_id = title.id', 'inner');
    //     $this->db->where('title.mahasiswa', $user_id); // assuming user_id is 2 for user2
    //     $query = $this->db->get();

    //     $bab_values = $query->result_array();

    //     $percentage = 0;
    //     foreach ($bab_values as $bab) {
    //         switch ($bab['bab']) {
    //             case 1:
    //                 $percentage = 25;
    //                 break;
    //             case 2:
    //                 $percentage = 60;
    //                 break;
    //             case 3:
    //                 $percentage = 80;
    //                 break;
    //             case 4:
    //                 $percentage = 100;
    //                 break;
    //             default:
    //                 $percentage += 0;
    //                 break;
    //         }
    //     }

    //     if (count($bab_values) > 0) {
    //         $total_bab = count($bab_values);
    //         $average_percentage = ($percentage / $total_bab);

    //         return round($average_percentage, 2); // return the average percentage rounded to two decimal places
    //     }
    //     return 0;
    // } // ... logic for calculating bimbingan percentage

    // public function get_seminar_percentage()
    // {
    //     // ... logic for calculating seminar percentage
    //     // Replace 'eminar_table' with the actual table name for seminar data
    //     $query = $this->db->select('COUNT(*) AS total_seminar')
    //         ->from('pro_progress')
    //         ->where('status', 'completed') // Assuming a column named "status" with value "completed" for completed seminars
    //         ->get();
    //     $total_seminar = $query->row()->total_seminar;

    //     // You need to have a total number of seminars (e.g., from another table or calculated)
    //     // Replace 'total_seminars' with the actual total number
    //     $total_seminars = 100; // Example: 100 total seminars

    //     $percentage = ($total_seminar / $total_seminars) * 100;
    //     return round($percentage, 2); // Return the percentage rounded to two decimal places
    // }



    //dosen
    public function getBelumDisetujuiJudul()
    {
        $user_id = $this->session->userdata('user_id'); // Mengambil user_id dari session

        $this->db->select('count(*) as total');
        $this->db->from('title');
        $this->db->join('users', 'title.mahasiswa = users.id');
        $this->db->where('title.status', 'Sedang diproses');
        $this->db->group_start();
        $this->db->where('title.dospem_1_id', $user_id);
        $this->db->or_where('title.dospem_2_id', $user_id);
        $this->db->group_end();
        $query = $this->db->get();

        return $query->row()->total; // Mengembalikan jumlah total
    }


    public function getMahasiswaDibimbing()
    {
        $user_id = $this->session->userdata('user_id'); // Mengambil user_id dari session

        // Subquery untuk mendapatkan ID terbaru dari setiap mahasiswa
        $subquery = $this->db->select('MAX(id) as id')
        ->from('title')
        ->where('status', 'Diterima')
        ->group_start()
            ->where('dospem_1_id', $user_id)
            ->or_where('dospem_2_id', $user_id)
            ->group_end()
            ->group_by('mahasiswa')
            ->get_compiled_select();

        // Kueri utama untuk menghitung jumlah judul terbaru yang disetujui dosen
        $this->db->select('count(*) as total');
        $this->db->from('title');
        $this->db->where("id IN ($subquery)", NULL, FALSE);
        $query = $this->db->get();

        return $query->row()->total; // Mengembalikan jumlah total
    }


    public function getBelumBimbingan()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    public function getBelumSeminar()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    public function getBelumSkripsi()
    {
        $query = $this->db->get('users');
        return $query->result();
    }


    public function get_dosen_mahasiswa()
    {
        $current_year = date('Y');
        $target_year = $current_year - 4;

        $this->db->select('u.id, u.nama, COUNT(DISTINCT m.id) AS jumlah_mahasiswa');
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


    public function get_guidance_count($mahasiswa_id)
    {
        $this->db->select('COUNT(*) as count');
        $this->db->from('pro_progress');
        $this->db->join('title', 'pro_progress.judul_id = title.id');
        $this->db->where('title.mahasiswa', $mahasiswa_id);
        $query_pro = $this->db->get()->row()->count;

        $this->db->select('COUNT(*) as count');
        $this->db->from('skp_progress');
        $this->db->join('title', 'skp_progress.judul_id = title.id');
        $this->db->where('title.mahasiswa', $mahasiswa_id);
        $query_skp = $this->db->get()->row()->count;

        return [$query_pro, $query_skp];
    }

    public function get_last_guidance_date($mahasiswa_id)
    {
        // Query for the last guidance date from pro_progress
        $this->db->select_max('tanggal');
        $this->db->from('pro_progress');
        $this->db->join('title', 'pro_progress.judul_id = title.id');
        $this->db->where('title.mahasiswa', $mahasiswa_id);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);
        $query_pro = $this->db->get()->row();

        // Query for the last guidance date from skp_progress
        $this->db->select_max('tanggal');
        $this->db->from('skp_progress');
        $this->db->join('title', 'skp_progress.judul_id = title.id');
        $this->db->where('title.mahasiswa', $mahasiswa_id);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);
        $query_skp = $this->db->get()->row();

        return [isset($query_pro->tanggal) ? $query_pro->tanggal : '-', isset($query_skp->tanggal) ? $query_skp->tanggal : '-'];
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

    public function count_pending_approval($dosen_id)
    {
        $this->db->select('COUNT(*) as jumlah_belum_disetujui');
        $this->db->from('pro_register pr');
        $this->db->join('title t', 'pr.title_id = t.id');
        $this->db->join('users u', '(t.dospem_1_id = u.id OR t.dospem_2_id = u.id)');
        $this->db->where('u.id', $dosen_id);
        $this->db->where('(pr.status_dospem_1 = "Sedang diproses" OR pr.status_dospem_2 = "Sedang diproses")');
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->jumlah_belum_disetujui : 0;
    }

    public function count_pending_approvalskp($dosen_id)
    {
        $this->db->select('COUNT(*) as jumlah_belum_disetujui');
        $this->db->from('skp_register pr');
        $this->db->join('title t', 'pr.title_id = t.id');
        $this->db->join('users u', '(t.dospem_1_id = u.id OR t.dospem_2_id = u.id)');
        $this->db->where('u.id', $dosen_id);
        $this->db->where('(pr.status_dospem_1 = "Sedang diproses" OR pr.status_dospem_2 = "Sedang diproses")');
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->jumlah_belum_disetujui : 0;
    }

    public function count_total_judul()
    {
        $this->db->select('COUNT(*) as total_judul');
        $this->db->from('title');
        $this->db->where('status', 'Diterima');
        $query = $this->db->get();
        return $query->row()->total_judul;
    }


    public function get_jumlah_jadwal()
    {
        // Mendapatkan tanggal hari ini
        $today = date('Y-m-d');

        // Mendapatkan tanggal besok
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        // Menjalankan query dengan query builder
        $this->db->from('pro_register');
        $this->db->where('tanggal >=', $today);
        $this->db->where('tanggal <=', $tomorrow);
        $count = $this->db->count_all_results();

        return $count;
    }

    public function get_jumlah_jadwal_Today()
    {
        // Mendapatkan tanggal hari ini
        $today = date('Y-m-d');

        // Mendapatkan tanggal besok
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        // Menjalankan query dengan query builder
        $this->db->from('pro_register');
        $this->db->where('tanggal =', $today);
        $this->db->where('tanggal <=', $tomorrow);
        $count = $this->db->count_all_results();

        return $count;
    }

    public function countDsn($user_id)
    {
        $today = date('Y-m-d');
        $this->db->select('COUNT(*) as count');
        $this->db->from('pro_register');
        $this->db->join('title', 'pro_register.title_id = title.id', 'inner');
        $this->db->where('pro_register.status', 'Diterima');
        $this->db->where('pro_register.tanggal', $today);
        $this->db->group_start();
        $this->db->or_where('title.dospem_1_id', $user_id);
        $this->db->or_where('title.dospem_2_id', $user_id);
        $this->db->or_where('title.dosuji_1_id', $user_id);
        $this->db->or_where('title.dosuji_2_id', $user_id);
        $this->db->group_end();
        $query = $this->db->get();
        $result = $query->row_array();

        $count = $result['count'];
        if ($count > 0) {
            return "$count jadwal ujian hari ini, segera cek jadwal anda";
        } else {
            return "Tidak ada jadwal ujian hari ini";
        }
    }



    public function getMhsToday($user_id)
    {
        $today = date('Y-m-d');

        // Select the necessary fields
        $this->db->select('COUNT(*) as count');
        $this->db->from('pro_register');
        $this->db->join('title', 'pro_register.title_id = title.id', 'inner');
        $this->db->where('title.mahasiswa', $user_id);
        $this->db->where('pro_register.status', 'Diterima');
        $this->db->where('DATE(pro_register.tanggal)', $today); // Filter by today's date
        $query = $this->db->get();

        // Get the count of approved schedules for today
        $count = $query->row()->count;

        // Return the appropriate message based on the count
        if ($count > 0) {
            return "$count jadwal ujian hari ini";
        } else {
            return "Tidak ada jadwal ujian hari ini";
        }
    }

	
}
