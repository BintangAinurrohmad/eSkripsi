<!DOCTYPE html>
<html>

<head>
  <title>Dashboard Koordinator Skripsi</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <h2><?php echo $user_name; ?>!</h2>
  <!-- Rest of your dashboard content -->
</body>

<body>
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
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Nama Dosen</th>
                      <th>DosPem1</th>
                      <th>DosPem2</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($dosen_mahasiswa as $data) : ?>
                      <tr>
                        <td><?= $data['nama_dosen']; ?></td>
                        <td><?= $data['pembimbing_1']; ?></td>
                        <td><?= $data['pembimbing_2']; ?></td>
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

  <!-- Card Pengumuman -->
  <section class="section">
    <div class="card">
      <div class="card-body pt-2">

        <h5 class="card-title">Pengumuman</h5>

        <table class="table datatable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col" class="col-md-4">Penulis</th>
              <th scope="col">Pengumuman</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($pengumuman as $pengumuman) { ?>
              <tr>
                <td>
                  <i class="ri-megaphone-fill"></>
                </td>
                <td class="col-md-4">
                  <?php
                  $creator = $this->db->where('id', $pengumuman->created_by)->get('users')->row();
                  echo $creator->nama;
                  ?>
                </td>
                <td>
                  <b><?= $pengumuman->title; ?></b><br />
                  <?= $pengumuman->content; ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>