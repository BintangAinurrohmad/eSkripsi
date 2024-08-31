<?php
date_default_timezone_set('Asia/Jakarta');
// Helper function to calculate time difference in a human-readable format
function timeAgo($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'tahun',
        'm' => 'bulan',
        'w' => 'minggu',
        'd' => 'hari',
        'h' => 'jam',
        'i' => 'menit',
        's' => 'detik',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
}


$no = 1;

$redirect_page_types = [
    "title-submission" => $this->session->userdata('group_id') == 3 ? 'title/koordinator' : 'title/dosen',
    "rejected_title" => "title/mahasiswa",
    "approved_title" => "title/mahasiswa",
    "new_progress" =>
    $this->session->userdata('group_id') == 2 ? 'progress_proposal/dosen' : 'progress_proposal/mahasiswa',
    "new_progress_skp" =>
    $this->session->userdata('group_id') == 2 ? 'progress_skripsi/dosen' : 'progress_skripsi/mahasiswa',

    "new_proregis" => $this->session->userdata('group_id') == 3 ? 'registration_proposal/koordinator' : 'registration_proposal/dosen',
    "acc_proregis" => $this->session->userdata('group_id') == 2 ? 'registration_proposal/dosen' : 'registration_proposal/mahasiswa',
    "de_proregis" => $this->session->userdata('group_id') == 2 ? 'registration_proposal/dosen' : 'registration_proposal/mahasiswa',

    "new_skpregris" => $this->session->userdata('group_id') == 3 ? 'registration_skripsi/koordinator' : 'registration_skripsi/dosen',
    "acc_skpregris" => $this->session->userdata('group_id') == 2 ? 'registration_skripsi/dosen' : 'registration_skripsi/mahasiswa',
    "de_skpregris" => $this->session->userdata('group_id') == 2 ? 'registration_skripsi/dosen' : 'registration_skripsi/mahasiswa',

    "update_pro" => $this->session->userdata('group_id') == 2 ? 'schedule_proposal/dosen' : 'schedule_proposal/mahasiswa',

    "update_skp" => $this->session->userdata('group_id') == 2 ? 'schedule_skripsi/dosen' : 'schedule_skripsi/mahasiswa',
];

foreach ($notif as $n) { ?>
    <a href="<?php echo isset($redirect_page_types[$n->page_type]) ? base_url($redirect_page_types[$n->page_type]) : '#' ?>">
        <div class="card">
            <div class="card-body p-3">
                <h4><i class=""><?= $n->judul ?></i></h4>

                <?= $n->pesan ?>
                <br>
                <br>
                <small>(<?= timeAgo($n->created_at) ?>)</small>
            </div>
        </div>
    </a>
<?php $no++;
} ?>