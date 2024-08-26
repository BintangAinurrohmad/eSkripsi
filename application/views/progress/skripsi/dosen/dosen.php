<!DOCTYPE html>
<html>
<section class="section">
  <div class="card">
    <div class="card-body">
      <p class="card-title"><a href="" class="text-black">Mahasiswa yang Anda Bimbing</a></p>
      <!-- Default Table -->

      <table class="table datatable">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">NPM</th>
            <th scope="col">Nama</th>
            <th scope="col">Judul</th>
            <th scope="col">Status Judul</th>
            <th scope="col">Status Bimbingan Proposal</th>
            <th scope="col">Status Ujian Proposal</th>
            <th scope="col">Status Bimbingan Skripsi</th>
            <th scope="col">Status Ujian Skripsi</th>
            <th scope="col">Status Revisi</th>
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
              <td><?= $row->status_judul ?></td>
              <td><?= $row->status_bimbingan_proposal ?></td>
              <td><?= $row->status_ujian_proposal ?></td>
              <td><?= $row->status_bimbingan_skripsi ?></td>
              <td><?= $row->status_ujian_skripsi ?></td>
              <td><?= $row->status_skripsi_selesai ?></td>
              <td>
                <a href="<?= base_url() ?>/progress_skripsi/dosen1/<?= $row->id ?>" class="btn btn-primary" style="border-radius: 10px;" type="submit">Bimbingan</a>
              </td>
            </tr>
          <?php $no++;
          } ?>
        </tbody>
      </table>
      <!-- End Default Table Example -->

    </div>
  </div>
</section>