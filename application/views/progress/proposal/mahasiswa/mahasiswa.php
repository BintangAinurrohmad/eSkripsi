<!DOCTYPE html>
<html>

<head>
  <!-- Add Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <!-- Add Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <style>
    .section {
      padding: 20px;
    }

    .card-title {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .card-body h5 {
      font-size: 1.2rem;
      margin-bottom: 20px;
    }

    .btn-custom {
      border-radius: 10px;
    }

    .table th,
    .table td {
      vertical-align: middle;
    }

    .badge-status {
      padding: 0.5em 0.75em;
      border-radius: 10px;
      font-size: 0.875rem;
      text-transform: capitalize;
    }
  </style>
</head>

<body>
  <section class="section">
    <?php if (($this->session->flashdata('error'))) { ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $this->session->flashdata('error'); ?>
      </div>
    <?php } ?>
    <div class="card mb-4">
      <div class="card-body">
        <h6 class="card-title pt-0">Judul Skripsi</h6>
        <h6 class="text-uppercase"><?= isset($my_title) ? $my_title->judul : '-'; ?></h6>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">Bimbingan</h5>
          <a href="<?= base_url() ?>/progress_proposal/mahasiswa1" class="btn btn-primary btn-custom">Tambah</a>
        </div>

        <table class="table table-striped">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Pembimbing</th>
              <!-- <th>BAB</th> -->
              <th>Pembahasan</th>
              <th>Bukti Bimbingan</th>
              <th>Status</th>
              <th>Hapus</th>
            </tr>
          </thead>
          <tbody>
            <?php
            setlocale(LC_TIME, 'id_ID.UTF-8'); // Set locale to Indonesian
            foreach ($data_proposal as $row) :
            ?>
              <tr>
                <td><?php echo strftime('%A, %d %B %Y', strtotime($row->tanggal)); ?></td>
                <td><?php echo $row->nama_pembimbing; ?></td>
                <!-- <td><?php echo $row->bab; ?></td> -->
                <td><?php echo $row->pembahasan; ?></td>
                <td>
                  <a href="<?php echo site_url('Progress_proposal/download_bukti/' . $row->id); ?>" class="btn btn-light btn-custom">
                    <button class="btn btn-success">Lihat</button>
                  </a>
                </td>
                <td>
                  <?php
                  $badge_class = '';
                  $status_text = '';
                  switch ($row->status) {
                    case 'approved':
                      $badge_class = 'badge-primary';
                      $status_text = 'Disetujui';
                      break;
                    case 'pending':
                      $badge_class = 'badge-warning';
                      $status_text = 'Menunggu Respon';
                      break;
                    case 'rejected':
                      $badge_class = 'badge-danger';
                      $status_text = 'Ditolak';
                      break;
                  }
                  ?>
                  <span class="badge badge-status <?php echo $badge_class; ?>"><?php echo $status_text; ?></span>
                </td>
                <td>
                  <a href="<?= site_url('Progress_proposal/delete_progress/' . $row->id) ?>" class="btn btn-danger btn-custom" onclick="return confirm('Apakah Anda yakin ingin menghapus proposal kemajuan ini?')">
                    <i class="ri-close-line"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="d-flex gap-3 mt-3">
          <!-- <a href="<?php echo site_url('Progress_proposal/download_log'); ?>" class="btn btn-primary btn-custom">
            <i class="fas fa-download"></i> Log
          </a> -->
          <div class="dropdown">
            <button class="btn btn-success btn-custom dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-download"></i> Berita Acara Bimbingan
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo site_url('Progress_proposal/progress_proposal_download_dospem1'); ?>">Dosen Pembimbing 1</a></li>
              <li><a class="dropdown-item" href="<?php echo site_url('Progress_proposal/progress_proposal_download_dospem2'); ?>">Dosen Pembimbing 2</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Add Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>