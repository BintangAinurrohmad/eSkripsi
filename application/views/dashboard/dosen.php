<!DOCTYPE html>
<html lang="en">

<body>

  <section class="section dashboard">
    <div class="row">

      <div class="card-body">
        <h6>
          <marquee behavior="scroll" direction="left">
            <?php echo $total_count; ?></marquee>
        </h6>
      </div>

      <!-- Judul Respon Card -->
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
      </div><!-- End  -->

      <!-- mahasiswa bimbingan -->
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
      </div><!-- End  -->

      <!-- Jadwal ujian -->
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
                    <span class="text-success small pt-1 fw-bold" class=""><?= $jumlahskp_belum_disetujui; ?> </span><span class="text-muted small"> perlu Direspon</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- End -->

    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>