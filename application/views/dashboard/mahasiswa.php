<section class="section dashboard">
  <div class="row">

    <!-- Approved Count -->
    <div class="card-body">
      <h6 class="scrolling-text">
        <p><?php echo isset($approved_count) ? $approved_count : '-'; ?></p>
      </h6>
    </div>

    <!-- Thesis Title Card -->
    <div class="col-12 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Judul Skripsi</div>
          <h5 class="text-uppercase"><?= isset($my_title) ? $my_title->judul : '-'; ?></h5>
          <?php if (isset($my_title)) : ?>
            <?php
            $status_class = '';
            switch ($my_title->status) {
              case 'Diterima':
                $status_class = 'badge-diterima';
                break;
              case 'Ditolak':
                $status_class = 'badge-ditolak';
                break;
              case 'Sedang diproses':
                $status_class = 'badge-sedang-diproses';
                break;
            }
            ?>
            <span class="<?= $status_class; ?>"><?= $my_title->status; ?></span>
          <?php else : ?>
            <p>Status: -</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Bimbingan Card -->
    <div class="col-xxl-6 col-md-6 mb-4">
      <div class="card info-card">
        <div class="card-body">
          <h5 class="card-title">
            <a href="<?= base_url() ?>Progress_proposal/">Bimbingan</a>
            <span>| Terbaru</span>
          </h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle">
              <i class="ri-article-line"></i>
            </div>
            <div class="ps-3">
              <div>
                <span class="text-muted small">Proposal</span>
                <span class="text-success small fw-bold"><?= isset($guidance_count) ? $guidance_count[0] : '-'; ?></span>
                <span class="text-muted small">Kali</span>
              </div>
              <div>
                <span class="text-muted small">Skripsi</span>
                <span class="text-success small fw-bold"><?= isset($guidance_count) ? $guidance_count[1] : '-'; ?></span>
                <span class="text-muted small">Kali</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Last Guidance Date Card -->
    <div class="col-xxl-6 col-md-6 mb-4">
      <div class="card info-card">
        <div class="card-body">
          <h5 class="card-title">
            <a href="<?= base_url() ?>Progress_proposal/">Terakhir Bimbingan</a>
            <span>| Tanggal</span>
          </h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle">
              <i class="ri-chat-history-line"></i>
            </div>
            <div class="ps-3">
              <div>
                <span class="text-muted small">Proposal</span>
                <span class="text-success small fw-bold"><?= isset($last_guidance_date) ? $last_guidance_date[0] : '-'; ?></span>
              </div>
              <div>
                <span class="text-muted small">Skripsi</span>
                <span class="text-success small fw-bold"><?= isset($last_guidance_date) ? $last_guidance_date[1] : '-'; ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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

<style>
  .scrolling-text {
    overflow: hidden;
    white-space: nowrap;
    box-sizing: border-box;
    animation: scrolling 30s linear infinite;
  }

  @keyframes scrolling {
    0% {
      transform: translateX(100%);
    }

    100% {
      transform: translateX(-100%);
    }
  }

  .badge-diterima {
    background-color: green;
    color: white;
    padding: 0.2em 0.4em;
    border-radius: 0.2em;
  }

  .badge-ditolak {
    background-color: red;
    color: white;
    padding: 0.2em 0.4em;
    border-radius: 0.2em;
  }

  .badge-sedang-diproses {
    background-color: orange;
    color: white;
    padding: 0.2em 0.4em;
    border-radius: 0.2em;
  }
</style>