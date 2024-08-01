<!DOCTYPE html>
<html>

<head>
  <title>Dashboard Koordinator Skripsi</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="card-body">
    <h6>
      <marquee behavior="scroll" direction="left">
        <?php echo $count; ?></marquee>
    </h6>
  </div>
  <section class="section dashboard">
    <div class="row">

          <!-- judul Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title"><a class="card-title" href="<?= base_url() ?>title/"> Judul Skripsi</a></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="ri-book-2-line"></i>
                  </div>
                  <div class="ps-3">
                    <span class="text-success small pt-1 fw-bold"><?php echo $total_judul; ?></span>
                    <span class="text-muted small pt-2 ps-1"> Judul</span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Card -->

          <!-- jadwal ujian Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title">Jadwal Ujian</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="ri-file-text-line"></i>
                  </div>
                  <div class="ps-3">
                    <span class="text-success small pt-1 fw-bold"><?php echo $jumlah_jadwal; ?></span>
                    <span class="text-muted small pt-2 ps-1"> Jadwal ,</span>
                  </div>
                  <div class="ps-3">
                    <span class="text-success small pt-1 fw-bold"><?php echo $jumlah_jadwal_today; ?></span>
                    <span class="text-muted small pt-2 ps-1"> Jadwal Hari Ini</span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Card -->

          <!-- Tabel Pembimbing dan Mahasiswa -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto pt-2">
              <div class="card-body">
                <h5 class="card-title">Dosen dan Jumlah Mahasiswa Bimbingan</h5>
                <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                  <table class="table table-stripped">
                    <thead>
                      <tr>
                        <th>Nama Dosen</th>
                        <th>Jumlah Mahasiswa</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($dosen_mahasiswa as $data) : ?>
                        <tr>
                          <td><?= $data['nama_dosen']; ?></td>
                          <td><?= $data['jumlah_mahasiswa']; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div><!-- End Tabel Pembimbing dan Mahasiswa -->

    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>