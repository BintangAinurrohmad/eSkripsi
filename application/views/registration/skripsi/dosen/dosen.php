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


			<ul class="nav nav-tabs mt-3" id="myTabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Pembimbing 1</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Pembimbing 2</a>
				</li>
			</ul>

			<div class="tab-content mt-2">
				<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">

					<!-- <div class="d-flex justify-content mt-3">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                </div> -->

					<?php if (empty($dospem1)) { ?>
						<p>Tidak ada pendaftaran ujian proposal yang menunggu persetujuan.</p>
					<?php } else { ?>

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">NPM</th>
									<th scope="col">Status</th>
									<th scope="col">Logbook Bimbingan</th>
									<th scope="col">Naskah Skripsi</th>
									<th scope="col">Lembar Persetujuan</th>
									<th scope="col">Transkrip Nilai</th>
									<th scope="col">Bukti Pembayaran</th>
									<th scope="col">Respon</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($dospem1 as $dospem1) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $dospem1->judul; ?></td>
										<td>
											<?php
											$mahasiswa = $this->db->where('id', $dospem1->mahasiswa)->get('users')->row();
											echo $mahasiswa->nama;
											?>
										</td>
										<td>
											<?php
											echo $mahasiswa->npm;
											?>
										</td>
										<td>
											<?php if ($dospem1->skp_status_dospem_1 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($dospem1->skp_status_dospem_1 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>progress_skripsi/dosen1/<?= $dospem1->mahasiswa ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/naskah/<?= $dospem1->file_naskah; ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/persetujuan/<?= $dospem1->file_persetujuan; ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/transkrip/<?= $dospem1->file_transkrip; ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/ukt/<?= $dospem1->file_ukt; ?>">Lihat</a></td>
										<td width="15%">
											<form id="updateStatus<?= $dospem1->skp_id ?>" action=" <?= base_url() ?>registration_skripsi/update_status_dospem1/<?= $dospem1->skp_id ?>" method="post">
												<div class="d-flex gap-3">
													<select name="status" id="status<?= $dospem1->skp_id ?>" class="form-control" onchange="this.form.submit();">
														<option value="Sedang diproses" <?php if ($dospem1->skp_status_dospem_1 == 'Sedang diproses') echo 'selected'; ?>>Sedang diproses</option>
														<option value="Diterima" <?php if ($dospem1->skp_status_dospem_1 == 'Diterima') echo 'selected'; ?>>Diterima</option>
														<option value="Ditolak" <?php if ($dospem1->skp_status_dospem_1 == 'Ditolak') echo 'selected'; ?>>Ditolak</option>
													</select>
												</div>
											</form>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					<?php } ?>

				</div>
				<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">

					<!-- <div class="d-flex justify-content mt-3">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                </div> -->

					<?php if (empty($dospem2)) { ?>
						<p>Tidak ada pendaftaran ujian proposal yang menunggu persetujuan.</p>
					<?php } else { ?>

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">NPM</th>
									<th scope="col">Status</th>
									<th scope="col">Logbook Bimbingan</th>
									<th scope="col">Naskah Skripsi</th>
									<th scope="col">Lembar Persetujuan</th>
									<th scope="col">Transkrip Nilai</th>
									<th scope="col">Bukti Pembayaran</th>
									<th scope="col">Respon</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($dospem2 as $dospem2) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $dospem2->judul; ?></td>
										<td>
											<?php
											$mahasiswa = $this->db->where('id', $dospem2->mahasiswa)->get('users')->row();
											echo $mahasiswa->nama;
											?>
										</td>
										<td>
											<?php
											echo $mahasiswa->npm;
											?>
										</td>
										<td>
											<?php if ($dospem2->skp_status_dospem_2 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($dospem2->skp_status_dospem_2 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>progress_skripsi/dosen1/<?= $dospem2->mahasiswa ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/naskah/<?= $dospem2->file_naskah; ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/persetujuan/<?= $dospem2->file_persetujuan; ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/transkrip/<?= $dospem2->file_transkrip; ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_skripsi/view_file/ukt/<?= $dospem2->file_ukt; ?>">Lihat</a></td>
										<td width="15%">
											<form id="updateStatus<?= $dospem2->skp_id ?>" action=" <?= base_url() ?>registration_skripsi/update_status_dospem2/<?= $dospem2->skp_id ?>" method="post">
												<div class="d-flex gap-3">
													<select name="status" id="status<?= $dospem2->skp_id ?>" class="form-control" onchange="this.form.submit();">
														<option value="Sedang diproses" <?php if ($dospem2->skp_status_dospem_2 == 'Sedang diproses') echo 'selected'; ?>>Sedang diproses</option>
														<option value="Diterima" <?php if ($dospem2->skp_status_dospem_2 == 'Diterima') echo 'selected'; ?>>Diterima</option>
														<option value="Ditolak" <?php if ($dospem2->skp_status_dospem_2 == 'Ditolak') echo 'selected'; ?>>Ditolak</option>
													</select>
												</div>
											</form>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					<?php } ?>

				</div>

			</div>
		</div>
</section>

<!-- <div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tolak Judul?</h4>
            </div>
            <div class="modal-body">
            <div class="form-floating mb-3">
                      <textarea class="form-control" placeholder="Berikan alasan" id="alasan" style="height: 100px;"></textarea>
                      <label for="alasan">Alasan</label>
            </div>
            <center><button type="submit" class="btn btn-danger">Tolak</button></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div> -->