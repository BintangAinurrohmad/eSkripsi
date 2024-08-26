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

      <h4><u>Mahasiswa Bimbingan Anda</u></h4>
      <!-- Table -->
      <table class="table table-striped table-hover datatable">
        <thead class="table-dark">
          <tr>
            <th scope="col">No</th>
            <th scope="col">NPM</th>
            <th scope="col">Nama</th>
            <th scope="col">Judul</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          if (!empty($proposal_data)) {
            foreach ($proposal_data as $row) { ?>
              <tr>
                <th scope="row"><?= $no ?></th>
                <td><?= $row->npm ?></td>
                <td><?= $row->nama ?></td>
                <td><?= $row->judul ?></td>
                <td>
                  <a href="<?= base_url() ?>/progress_proposal/dosen1/<?= $row->id ?>" class="btn btn-primary btn-sm" type="submit">Progress</a>
                </td>
              </tr>
            <?php
              $no++;
            }
          } else { ?>
            <tr>
              <td colspan="5" class="text-center">Tidak ada data mahasiswa yang dibimbing</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

</html>