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

      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">


          <u>
            <h5>Koordinator</h5>
          </u>

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
                    <span class="text-muted small pt-2 ps-1">Perlu Di Respon</span>
                  </div>
                  <!-- <div class="ps-3">
                    <span class="text-muted small pt-2 ps-1">Disetujui :</span>
                    <span class="text-success small pt-1 fw-bold">12</span>
                  </div> -->
                </div>
              </div>
            </div>
          </div><!-- End Card -->

          <!-- judul Card -->
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

          <u>
            <h5>Dosen</h5>
          </u>

          <!-- judul1 Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

              <div class="card-body">
                <h5 class="card-title"><a class="card-title" href="<?= base_url() ?>title/">Judul Perlu Disetujui</a></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="ri-user-follow-line"></i>
                  </div>
                  <div class="ps-3">
                    <span class="text-success small pt-1 fw-bold" class=""><?= $judul; ?> </span><span class="text-muted small">mahasiswa</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Card -->

          <!-- jlh mhs Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title"><a class="card-title" href="<?= base_url() ?>Progress_proposal/">Mahasiswa yang Dibimbing</a></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <span class="text-success small pt-1 fw-bold" class=""><?= $dibimbing; ?> </span><span class="text-muted small">mahasiswa</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Card -->

          <!-- jadwal Card -->
          <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
              <div class="card-body">
                <!-- <h5 class="card-title">Summary <span>| This Year</span></h5> -->
                <div class="row">
                  <!-- Left Customer Section -->
                  <div class="col-6">
                    <h5 class="card-title"><a class="card-title" href="<?= base_url() ?>Registration_Proposal/">Daftar Ujian Proposal</a></h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ri-calendar-todo-line"></i>
                      </div>
                      <div class="ps-3">
                        <span class="text-success small pt-1 fw-bold" class=""><?php echo $jumlah_belum_disetujui; ?></span><span class="text-muted small"> Perlu Direspon</span>
                      </div>
                    </div>
                  </div>
                  <!-- Right Seller Section -->
                  <div class="col-6">
                    <h5 class="card-title"><a class="card-title" href="<?= base_url() ?>Registration_Skripsi/">Daftar Ujian Skripsi</a></h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="ri-calendar-todo-line"></i>
                      </div>
                      <div class="ps-3">
                        <span class="text-success small pt-1 fw-bold" class=""><?= $jumlahskp_belum_disetujui; ?> </span><span class="text-muted small"> Perlu Direspon</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Card -->

        </div>
      </div><!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="col-lg-4">

        <!-- Pembimbing dan mahasiswa nya -->
        <div class="col-12 pt-4">
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
        </div><!-- End -->

      </div><!-- End Right side columns -->

    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>