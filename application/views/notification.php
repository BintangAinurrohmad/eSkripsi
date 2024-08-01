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
foreach ($notif as $n) { ?>
    <div class="card">
        <div class="card-body p-3">
            <h4><?= $n->judul ?></h4>

            <?= $n->pesan ?>
            <br>
            <br>
            <small>(<?= timeAgo($n->created_at) ?>)</small>
        </div>
    </div>
<?php $no++;
} ?>