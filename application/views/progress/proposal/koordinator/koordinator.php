<!DOCTYPE html>
<html>
<section class="section">
  <div class="card">
    <div class="card-body">
      <p class="card-title"><a href="" class="text-black">Mahasiswa yang Anda Bimbing</a></p>
      <!-- Default Table -->

      <!-- <div class="d-flex justify-content">
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
          <button class="btn btn-outline-primary" type="submit">
            <i class="ri-search-line"></i>
          </button>
        </form>
      </div> -->

      <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Judul</th>
            <th scope="col">Mahasiswa</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($proposal_data as $row) { ?>
            <tr>
              <th scope="row"><?= $no ?></th>
              <td><?= $row->judul ?></td>
              <td><?= $row->nama ?></td>
              <td>
                <a href="<?= base_url() ?>/progress_proposal/dosen1/<?= $row->id ?>" class="btn btn-primary" style="border-radius: 10px;" type="submit">progress</a>
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