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
					<a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Pembimbing 1</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Pembimbing 2</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Koordinator</a>
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
									<th scope="col">Naskah Proposal</th>
									<th scope="col">Lembar Persetujuan</th>
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
											<?php if ($dospem1->pro_status_dospem_1 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($dospem1->pro_status_dospem_1 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>progress_proposal/dosen1/<?= $dospem1->mahasiswa ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_proposal/view_file/naskah/<?= $dospem1->file_naskah; ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_proposal/view_file/persetujuan/<?= $dospem1->file_persetujuan; ?>">Lihat</a></td>
										<td width="15%">
											<form id="updateStatus<?= $dospem1->pro_id ?>" action=" <?= base_url() ?>registration_proposal/update_status_dospem1/<?= $dospem1->pro_id ?>" method="post">
												<div class="d-flex gap-3">
													<select name="status" id="status<?= $dospem1->pro_id ?>" class="form-control" onchange="this.form.submit();">
														<option value="Sedang diproses" <?php if ($dospem1->pro_status_dospem_1 == 'Sedang diproses') echo 'selected'; ?>>Sedang diproses</option>
														<option value="Diterima" <?php if ($dospem1->pro_status_dospem_1 == 'Diterima') echo 'selected'; ?>>Diterima</option>
														<option value="Ditolak" <?php if ($dospem1->pro_status_dospem_1 == 'Ditolak') echo 'selected'; ?>>Ditolak</option>
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
									<th scope="col">Naskah Proposal</th>
									<th scope="col">Lembar Persetujuan</th>
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
											<?php if ($dospem2->pro_status_dospem_2 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($dospem2->pro_status_dospem_2 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>progress_proposal/dosen1/<?= $dospem2->mahasiswa ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_proposal/view_file/naskah/<?= $dospem2->file_naskah; ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_proposal/view_file/persetujuan/<?= $dospem2->file_persetujuan; ?>">Lihat</a></td>
										<td width="15%">
											<form id="updateStatus<?= $dospem2->pro_id ?>" action=" <?= base_url() ?>registration_proposal/update_status_dospem2/<?= $dospem2->pro_id ?>" method="post">
												<div class="d-flex gap-3">
													<select name="status" id="status<?= $dospem2->pro_id ?>" class="form-control" onchange="this.form.submit();">
														<option value="Sedang diproses" <?php if ($dospem2->pro_status_dospem_2 == 'Sedang diproses') echo 'selected'; ?>>Sedang diproses</option>
														<option value="Diterima" <?php if ($dospem2->pro_status_dospem_2 == 'Diterima') echo 'selected'; ?>>Diterima</option>
														<option value="Ditolak" <?php if ($dospem2->pro_status_dospem_2 == 'Ditolak') echo 'selected'; ?>>Ditolak</option>
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

				<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">

					<?php if (empty($koordinator)) { ?>
						<p>Tidak ada pendaftaran ujian proposal yang menunggu persetujuan.</p>
					<?php } else { ?>

						<table class="table">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">Pembimbing 1</th>
									<th scope="col">Pembimbing 2</th>
									<th scope="col">Naskah Proposal</th>
									<th scope="col">Lembar Persetujuan</th>
									<th scope="col">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($koordinator as $data3) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $data3->judul; ?></td>
										<td>
											<?php
											$mahasiswa = $this->db->where('id', $data3->mahasiswa)->get('users')->row();
											echo $mahasiswa->nama;
											?>
										</td>
										<td>
											<?php
											$dosen1 = $this->db->where('id', $data3->dospem_1_id)->get('users')->row();
											echo $dosen1->nama;
											?>
											<br />
											<?php if ($data3->pro_status_dospem_1 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($data3->pro_status_dospem_1 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td>
											<?php
											$dosen2 = $this->db->where('id', $data3->dospem_2_id)->get('users')->row();
											echo $dosen2->nama;
											?>
											<br />
											<?php if ($data3->pro_status_dospem_2 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($data3->pro_status_dospem_2 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_proposal/view_file/naskah/<?= $data3->file_naskah; ?>">Lihat</a></td>
										<td><a class="btn btn-primary" href="<?= base_url() ?>registration_proposal/view_file/persetujuan/<?= $data3->file_persetujuan; ?>">Lihat</a></td>
										<td>
											<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal<?= $data3->pro_id; ?>">Terima</button>
											<a href="<?= base_url('registration_proposal/deProposal') ?>/<?= $data3->pro_id; ?>" class="btn btn-danger">Tolak</a>
										</td>
									</tr>

									<div class="modal fade" id="myModal<?= $data3->pro_id; ?>" tabindex="-1">
										<div class="modal-dialog">
											<div class="modal-content">
												<!-- Modal Header -->
												<div class="modal-header">
													<h4 class="modal-title">Atur Jadwal</h4>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<form class="row g-3 needs-validation border-top" action="<?php echo base_url('registration_proposal/accProposal'); ?>" method="post" novalidate>

														<input type="hidden" id="id" name="id" value="<?= $data3->pro_id; ?>">
														<input type="hidden" id="title_id" name="title_id" value="<?= $data3->title_id; ?>">
														<input type="hidden" id="dospem1" name="dospem1" value="<?= $data3->dospem_1_id; ?>">
														<input type="hidden" id="dospem2" name="dospem2" value="<?= $data3->dospem_2_id; ?>">

														<div class="col-12">
															<label for="tanggal" class="form-label">Tanggal</label>
															<div class="input-group has-validation">
																<input type="date" name="tanggal" class="form-control" id="tanggal" placeholder="Pilih Tanggal" required>
															</div>
														</div>

														<div class="col-12">
															<label for="jam" class="form-label">Jam</label>
															<input type="time" name="jam" class="form-control" id="jam" placeholder="Pilih Jam" required>
														</div>

														<div class="col-12">
															<label for="title_id" class="form-label">Ruangan</label>
															<select class="form-select" name="room_id" id="room_id" aria-label="Default select example">
																<option selected="">-- Pilih Ruangan Ujian --</option>
																<?php foreach ($rooms as $room) : ?>
																	<option value="<?= $room['id']; ?>" <?= set_select('id', $room['id']); ?>><?= $room['nama']; ?></option>
																<?php endforeach; ?>
															</select>
														</div>

														<div class="col-12">
															<label for="title_id" class="form-label">Dosen Penguji 1</label>
															<select class="form-select" name="dosuji1" id="dosuji1" aria-label="Default select example">
																<option selected="">-- Pilih Penguji 1 --</option>
																<?php foreach ($dosuji1 as $penguji1) : ?>
																	<option value="<?= $penguji1['id']; ?>" <?= set_select('id', $penguji1['id']); ?>><?= $penguji1['nama']; ?></option>
																<?php endforeach; ?>
															</select>
														</div>

														<div class="col-12">
															<label for="title_id" class="form-label">Dosen Penguji 2</label>
															<select class="form-select" name="dosuji2" id="dosuji2" aria-label="Default select example">
																<option selected="">-- Pilih Penguji 2 --</option>
																<?php foreach ($dosuji2 as $penguji2) : ?>
																	<option value="<?= $penguji2['id']; ?>" <?= set_select('id', $penguji2['id']); ?>><?= $penguji2['nama']; ?></option>
																<?php endforeach; ?>
															</select>
														</div>

														<div class="col-12 mt-3" align="center">
															<button class="btn btn-primary" style="border-radius: 15px;" type="submit">Atur Jadwal</button>
														</div>
													</form>
												</div>
												<!-- Modal Footer -->
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
												</div>
											</div>
										</div>
									</div>

								<?php } ?>
							</tbody>
						</table>

					<?php } ?>

				</div>
			</div>
		</div>
	</div>
</section>