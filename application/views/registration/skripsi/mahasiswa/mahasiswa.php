<section class="section">
	<div class="card">
		<div class="card-body">

			<h5 class="card-title">Ujian Saya</h5>

			<?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-info alert-dismissible fade show" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<?php if (empty($mySkripsi)) { ?>
				<p>Anda belum mendaftar untuk mengikuti ujian skripsi.</p>
			<?php } else { ?>

				<table class="table datatable">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Judul</th>
							<th scope="col">Naskah</th>
							<th scope="col">Lembar Persetujuan</th>
							<th scope="col">Transkrip Nilai</th>
							<th scope="col">Bukti Pembayaran</th>
							<th scope="col">Pembimbing 1</th>
							<th scope="col">Pembimbing 2</th>
							<th scope="col">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($mySkripsi as $skripsi) { ?>
							<tr>
								<th scope="row"><?= $no++; ?></th>
								<td><?= $skripsi->judul; ?></td>
								<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/naskah/<?= $skripsi->file_naskah; ?>">Lihat</a></td>
								<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/persetujuan/<?= $skripsi->file_persetujuan; ?>">Lihat</a></td>
								<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/transkrip/<?= $skripsi->file_transkrip; ?>">Lihat</a></td>
								<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/ukt/<?= $skripsi->file_ukt; ?>">Lihat</a></td></td>
								<td>
									<?php
									$dosen1 = $this->db->where('id', $skripsi->dospem_1_id)->get('users')->row();
									echo $dosen1->nama;
									?>
									<br />
									<?php if ($skripsi->skp_status_dospem_1 == "Diterima") { ?>
										<span class="badge rounded-pill bg-success">Diterima</span>
									<?php } else if ($skripsi->skp_status_dospem_1 == "Ditolak") { ?>
										<span class="badge rounded-pill bg-danger">Ditolak</span>
									<?php } else { ?>
										<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
									<?php } ?>
								</td>
								<td>
									<?php
									$dosen2 = $this->db->where('id', $skripsi->dospem_2_id)->get('users')->row();
									echo $dosen2->nama;
									?>
									<br />
									<?php if ($skripsi->skp_status_dospem_2 == "Diterima") { ?>
										<span class="badge rounded-pill bg-success">Diterima</span>
									<?php } else if ($skripsi->skp_status_dospem_2 == "Ditolak") { ?>
										<span class="badge rounded-pill bg-danger">Ditolak</span>
									<?php } else { ?>
										<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
									<?php } ?>
								</td>
								<td>
									<?php if ($skripsi->skp_status_dospem_1 == "Sedang diproses" || $skripsi->skp_status_dospem_2 == "Sedang diproses") { ?>
										<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
									<?php } else { ?>
										<?php if ($skripsi->skp_status == "Diterima") { ?>
											<span class="badge rounded-pill bg-success">Diterima</span>
										<?php } else if ($skripsi->skp_status == "Ditolak") { ?>
											<span class="badge rounded-pill bg-danger">Ditolak</span>
										<?php } else { ?>
											<span class="badge rounded-pill bg-info">Menunggu Penjadwalan</span>
										<?php } ?>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

			<?php } ?>
			<!-- End Default Table Example -->


			<?php
			// Logika untuk menampilkan tombol tambah
			$showAddButton = true;
			if (is_array($mySkripsi) && !empty($mySkripsi)) {
				$latestSkripsi = $mySkripsi[0]; // Ambil skpposal terbaru
				if ($latestSkripsi->skp_status == "Sedang proses") {
					$showAddButton = false;
				} elseif ($latestSkripsi->skp_status == "Ditolak") {
					$showAddButton = true;
				} else {
					$showAddButton = false;
				}
			} else {
				$showAddButton = true;
			}
			?>

			<?php if ($showAddButton) : ?>
				<a class="btn btn-primary position-absolute top-0 end-0 m-3" href="<?= base_url() ?>registration_skripsi/daftar" style="border-radius: 15px;">
					<i class="ri-add-line"></i>
					Tambah
				</a>
			<?php endif; ?>

		</div>
	</div>
</section>


<!-- <div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                  <span class="col-sm-5"><b>Judul</b></span>
                  <span class="col-sm-10">Sistem Informasi Balbla</span>
                </div>
                <div class="row">
                  <span class="col-sm-5"><b>Mahasiswa</b></span>
                  <span class="col-sm-10">Muhammad Amin (1412100017)</span>
                </div>
                <hr>
                <div class="row">
                  <span class="col-sm-5"><b>Pembimbing 1</b></span>
                  <span class="col-sm-10">Amaludin Arifia, S.Kom. M.Kom.</span>
                </div>
                <div class="row">
                  <span class="col-sm-5"><b>Status</b></span>
                  <span class="col-sm-10">Diterima</span>
                </div>
                <hr>
                <div class="row">
                  <span class="col-sm-5"><b>Pembimbing 2</b></span>
                  <span class="col-sm-10">Andik Adi Suryanto, S.T. M.T.</span>
                </div>
                <div class="row">
                  <span class="col-sm-5"><b>Status</b></span>
                  <span class="col-sm-10">Ditolak</span>
                </div>
                <hr>
                <div class="row">
                  <span class="col-sm-5"><b>Status Akhir</b></span>
                  <span class="col-sm-10">Sedang Diskpses</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div> -->
