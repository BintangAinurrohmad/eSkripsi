<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add necessary meta tags and other head content here -->
    <title><?php echo $title; ?></title>
    <!-- Add Bootstrap CSS for badge styling -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="tab-content pt-2">
                    <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Judul</th>
                                    <th>Pembimbing</th>
                                    <th>Bab</th>
                                    <th>Pembahasan</th>
                                    <th>Bukti Bimbingan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_skripsi as $row) : ?>
                                    <tr>
                                        <td><?php echo date('l, d F Y', strtotime($row->tanggal)); ?></td>
                                        <td><?php echo $row->judul; ?></td>
                                        <td><?php echo $row->nama_pembimbing; ?></td>
                                        <td><?php echo $row->bab; ?></td>
                                        <td><?php echo $row->pembahasan; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('Progress_skripsi/download_bukti/' . $row->id); ?>">
                                                <button class="btn btn-success">Lihat</button>
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($row->status) {
                                                case 'pending':
                                                    $status_text = 'Menunggu Disetujui';
                                                    $badge_class = 'badge-warning';
                                                    break;
                                                case 'approved':
                                                    $status_text = 'Disetujui';
                                                    $badge_class = 'badge-success';
                                                    break;
                                                case 'rejected':
                                                    $status_text = 'Ditolak';
                                                    $badge_class = 'badge-danger';
                                                    break;
                                                default:
                                                    $status_text = 'Tidak Diketahui';
                                                    $badge_class = 'badge-secondary';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>"><?php echo $status_text; ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Uncomment this if you need to provide download log functionality -->
                        <!-- <a href="<?php echo site_url('Progress_skripsi/download_log'); ?>">
                        <button class="btn btn-primary">Unduh Log</button>
                    </a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>