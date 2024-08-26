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

      <ul class="nav nav-tabs mt-3" id="myTabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="tab3-tab" data-bs-toggle="tab" href="#tab3" role="tab" aria-controls="tab3"
            aria-selected="false">Koordinator</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tab1-tab" data-bs-toggle="tab" href="#tab1" role="tab"
            aria-controls="tab1" aria-selected="true">Pembimbing</a>
        </li>

      </ul>

      <div class="tab-content mt-2">
        <div class="tab-pane" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">

          <h4><u> Mahasiswa bimbingan anda</u></h4>
          <!-- Default Table -->

          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">NPM</th>
                <th scope="col">Nama</th>
                <th scope="col">Judul</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($skripsi_data as $row) { ?>
                <tr>
                  <th scope="row"><?= $no ?></th>
                  <td><?= $row->npm ?></td>
                  <td><?= $row->nama ?></td>
                  <td><?= $row->judul ?></td>
                  <td>
                    <a href="<?= base_url() ?>/progress_skripsi/dosen1/<?= $row->id ?>" class="btn btn-primary" style="border-radius: 10px;" type="submit">progress</a>
                  </td>
                </tr>
              <?php $no++;
              } ?>
            </tbody>
          </table>
          <!-- End Default Table Example -->

        </div>

        <div class="tab-pane fade show active" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
          <h4><u>Semua Mahasiswa</u></h4>

          <!-- Filter Form -->
          <form class="row g-3 mb-4" action="<?php echo base_url('progress_proposal/koordinator'); ?>" method="get">
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
                <option value="">-- Select Status --</option>
                <option value="Judul Diterima" <?php echo $this->input->get('status_terakhir') == 'Judul Diterima' ? 'selected' : ''; ?>>Judul Diterima</option>
                <option value="Bimbingan Proposal" <?php echo $this->input->get('status_terakhir') == 'Bimbingan Proposal' ? 'selected' : ''; ?>>Bimbingan Proposal</option>
                <option value="Ujian Proposal" <?php echo $this->input->get('status_terakhir') == 'Ujian Proposal' ? 'selected' : ''; ?>>Ujian Proposal</option>
                <option value="Bimbingan Skripsi" <?php echo $this->input->get('status_terakhir') == 'Bimbingan Skripsi' ? 'selected' : ''; ?>>Bimbingan Skripsi</option>
                <option value="Ujian Skripsi" <?php echo $this->input->get('status_terakhir') == 'Ujian Skripsi' ? 'selected' : ''; ?>>Ujian Skripsi</option>
                <option value="Skripsi Selesai" <?php echo $this->input->get('status_terakhir') == 'Skripsi Selesai' ? 'selected' : ''; ?>>Skripsi Selesai</option>
              </select>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-success">Filter</button>
            </div>
          </form>

          <!-- Table -->
          <table class="table table-striped table-hover datatable">
            <thead class="table-dark">
              <tr>
                <th>Nama</th>
                <th>NPM</th>
                <th>Status Judul</th>
                <th>Status Bimbingan Proposal</th>
                <th>Status Ujian Proposal</th>
                <th>Status Bimbingan Skripsi</th>
                <th>Status Ujian Skripsi</th>
                <th>Status Revisi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($mahasiswa_data as $mhs) : ?>
                <tr>
                  <td><?= $mhs['nama']; ?></td>
                  <td><?= $mhs['npm']; ?></td>
                  <td><?= $mhs['status_judul']; ?></td>
                  <td><?= $mhs['status_bimbingan_proposal']; ?></td>
                  <td><?= $mhs['status_ujian_proposal']; ?></td>
                  <td><?= $mhs['status_bimbingan_skripsi']; ?></td>
                  <td><?= $mhs['status_ujian_skripsi']; ?></td>
                  <td><?= $mhs['status_skripsi_selesai']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

</html>