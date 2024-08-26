<!DOCTYPE html>
<html>

<section class="section">
  <div class="card">
    <div class="card-body">

      <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
          <?php echo $this->session->flashdata('success'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('denied')) : ?>
        <div class="alert alert-secondary alert-dismissible fade show mt-3" role="alert">
          <?php echo $this->session->flashdata('denied'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
          <?php echo $this->session->flashdata('error'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <h4 class="pt-4"><u>Semua Mahasiswa</u></h4>

      <!-- Filter Form -->
      <form class="row g-3 mb-4" action="<?php echo base_url('Tracking_mhs/track_mhs'); ?>" method="get">
        <div class="col-md-4">
          <label for="angkatan" class="form-label">Angkatan:</label>
          <input type="text" class="form-control" name="angkatan" id="angkatan" value="<?php echo $this->input->get('angkatan'); ?>">
        </div>

        <div class="col-md-4">
          <label for="npm" class="form-label">NPM:</label>
          <input type="text" class="form-control" name="npm" id="npm" value="<?php echo $this->input->get('npm'); ?>">
        </div>

        <div class="col-md-4">
          <label for="status_terakhir" class="form-label">Status Terakhir:</label>
          <select class="form-select" name="status_terakhir" id="status_terakhir">
            <option value="">-- Pilih Status --</option>
            <option value="Judul Diterima" <?php echo $this->input->get('status_terakhir') == 'Judul Diterima' ? 'selected' : ''; ?>>Judul Diterima</option>
            <option value="Bimbingan Proposal" <?php echo $this->input->get('status_terakhir') == 'Bimbingan Proposal' ? 'selected' : ''; ?>>Bimbingan Proposal</option>
            <option value="Ujian Proposal" <?php echo $this->input->get('status_terakhir') == 'Ujian Proposal' ? 'selected' : ''; ?>>Ujian Proposal</option>
            <option value="Bimbingan Skripsi" <?php echo $this->input->get('status_terakhir') == 'Bimbingan Skripsi' ? 'selected' : ''; ?>>Bimbingan Skripsi</option>
            <option value="Ujian Skripsi" <?php echo $this->input->get('status_terakhir') == 'Ujian Skripsi' ? 'selected' : ''; ?>>Ujian Skripsi</option>
            <option value="Skripsi Selesai" <?php echo $this->input->get('status_terakhir') == 'Skripsi Selesai' ? 'selected' : ''; ?>>Skripsi Selesai</option>
          </select>
        </div>

        <!-- Dropdown Nama Pembimbing 1 -->
        <div class="col-md-4">
          <label for="dospem_1_nama" class="form-label">Nama Pembimbing 1:</label>
          <select class="form-select" name="dospem_1_nama" id="dospem_1_nama">
            <option value="">-- Pilih Dosen --</option>
            <?php foreach ($dosen_list as $dosen) : ?>
              <option value="<?= $dosen['nama']; ?>" <?= $this->input->get('dospem_1_nama') == $dosen['nama'] ? 'selected' : ''; ?>>
                <?= $dosen['nama']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Dropdown Nama Pembimbing 2 -->
        <div class="col-md-4">
          <label for="dospem_2_nama" class="form-label">Nama Pembimbing 2:</label>
          <select class="form-select" name="dospem_2_nama" id="dospem_2_nama">
            <option value="">-- Pilih Dosen --</option>
            <?php foreach ($dosen_list as $dosen) : ?>
              <option value="<?= $dosen['nama']; ?>" <?= $this->input->get('dospem_2_nama') == $dosen['nama'] ? 'selected' : ''; ?>>
                <?= $dosen['nama']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-success">Filter</button>
        </div>
      </form>

      <!-- Table -->
      <!-- Table -->
      <table class="table table-striped table-hover datatable">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NPM</th>
            <th>Status Judul</th>
            <th>Status Bimbingan Proposal</th>
            <th>Status Ujian Proposal</th>
            <th>Status Bimbingan Skripsi</th>
            <th>Status Ujian Skripsi</th>
            <th>Status Skripsi Selesai</th>
            <th>Dosen Pembimbing 1</th>
            <th>Dosen Pembimbing 2</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($mahasiswa_data)): ?>
            <?php foreach ($mahasiswa_data as $i => $mhs) : ?>
              <tr>
                <td><?= $i + 1; ?></td>
                <td><?= $mhs['nama']; ?></td>
                <td><?= $mhs['npm']; ?></td>
                <td><?= $mhs['status_judul']; ?></td>
                <td><?= $mhs['status_bimbingan_proposal']; ?></td>
                <td><?= $mhs['status_ujian_proposal']; ?></td>
                <td><?= $mhs['status_bimbingan_skripsi']; ?></td>
                <td><?= $mhs['status_ujian_skripsi']; ?></td>
                <td><?= $mhs['status_skripsi_selesai']; ?></td>
                <td><?= $mhs['dospem_1_nama']; ?></td>
                <td><?= $mhs['dospem_2_nama']; ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="11" class="text-center">Tidak ada data ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <a href="<?= base_url('Tracking_mhs/word_export') . '?' . http_build_query($_GET); ?>" class="btn btn-primary">Download Log</a>

    </div>
  </div>
</section>

</html>