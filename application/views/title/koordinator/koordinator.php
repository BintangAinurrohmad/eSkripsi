<section class="section">
	<div class="card">
		<div class="card-body">

			<?php
			$alerts = ['success' => 'info', 'denied' => 'secondary', 'error' => 'danger'];
			foreach ($alerts as $key => $type) {
				if ($this->session->flashdata($key)) : ?>
					<div class="alert alert-<?= $type ?> alert-dismissible fade show mt-3" role="alert">
						<?= $this->session->flashdata($key); ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
			<?php endif;
			} ?>

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
				<li class="nav-item">
					<a class="nav-link" id="tab4-tab" data-bs-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Semua Judul</a>
				</li>
			</ul>

			<div class="tab-content mt-2">
				<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
					<?php if (empty($dospem1)) { ?>
						<p>Tidak ada judul yang menunggu persetujuan.</p>
					<?php } else { ?>
						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Bidang</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">NPM</th>
									<th scope="col">Tanggal Diajukan</th>
									<th scope="col">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($dospem1 as $item) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $item->judul; ?></td>
										<td><?= $this->db->where('id', $item->bidang_id)->get('research_area')->row()->nama; ?></td>
										<td><?= $this->db->where('id', $item->mahasiswa)->get('users')->row()->nama; ?></td>
										<td><?= $this->db->where('id', $item->mahasiswa)->get('users')->row()->npm; ?></td>
										<td><?= format_tgl($item->tanggal_pengajuan); ?></td>
										<td>
											<form action="<?= base_url('title/accDospem1'); ?>" method="post">
												<input type="hidden" id="id" name="id" value="<?= $item->id; ?>">
												<button type="submit" class="btn btn-primary">Terima</button>
											</form>
											<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?= $item->id; ?>">Tolak</button>
										</td>
									</tr>
									<div class="modal fade" id="myModal<?= $item->id; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Tolak Judul?</h4>
												</div>
												<div class="modal-body">
													<form action="<?= base_url('title/deDospem1'); ?>" method="post">
														<input type="hidden" id="id" name="id" value="<?= $item->id; ?>">
														<div class="form-floating mb-3">
															<textarea class="form-control" placeholder="Berikan alasan" name="alasan" id="alasan" style="height: 100px;"></textarea>
															<label for="alasan">Alasan</label>
														</div>
														<p align="center"><button type="submit" class="btn btn-danger">Tolak</button></p>
													</form>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
							</tbody>
						</table>
					<?php } ?>
				</div>

				<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
					<?php if (empty($dospem2)) { ?>
						<p>Tidak ada judul yang menunggu persetujuan.</p>
					<?php } else { ?>
						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Bidang</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">NPM</th>
									<th scope="col">Tanggal Diajukan</th>
									<th scope="col">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($dospem2 as $item) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $item->judul; ?></td>
										<td><?= $this->db->where('id', $item->bidang_id)->get('research_area')->row()->nama; ?></td>
										<td><?= $this->db->where('id', $item->mahasiswa)->get('users')->row()->nama; ?></td>
										<td><?= $this->db->where('id', $item->mahasiswa)->get('users')->row()->npm; ?></td>
										<td><?= format_tgl($item->tanggal_pengajuan); ?></td>
										<td>
											<form action="<?= base_url('title/accDospem2'); ?>" method="post">
												<input type="hidden" id="id" name="id" value="<?= $item->id; ?>">
												<button type="submit" class="btn btn-primary">Terima</button>
											</form>
											<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#myModal2<?= $item->id; ?>">Tolak</button>
										</td>
									</tr>
									<div class="modal fade" id="myModal2<?= $item->id; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Tolak Judul?</h4>
												</div>
												<div class="modal-body">
													<form action="<?= base_url('title/deDospem2'); ?>" method="post">
														<input type="hidden" id="id" name="id" value="<?= $item->id; ?>">
														<div class="form-floating mb-3">
															<textarea class="form-control" placeholder="Berikan alasan" name="alasan" id="alasan" style="height: 100px;"></textarea>
															<label for="alasan">Alasan</label>
														</div>
														<p align="center"><button type="submit" class="btn btn-danger">Tolak</button></p>
													</form>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
							</tbody>
						</table>
					<?php } ?>
				</div>

				<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
					<?php if (empty($titleKo)) { ?>
						<p>Tidak ada judul yang menunggu persetujuan.</p>
					<?php } else { ?>
						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">Pembimbing 1</th>
									<th scope="col">Status Pembimbing 1</th>
									<th scope="col">Pembimbing 2</th>
									<th scope="col">Status Pembimbing 2</th>
									<th scope="col">Detail</th>
									<th scope="col">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($titleKo as $item) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $item->judul; ?></td>
										<td><?= $this->db->where('id', $item->mahasiswa)->get('users')->row()->nama; ?></td>
										<td><?= $this->db->where('id', $item->dospem_1_id)->get('users')->row()->nama; ?></td>
										<td>
											<?php if ($item->status_dospem_1 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($item->status_dospem_1 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td><?= $this->db->where('id', $item->dospem_2_id)->get('users')->row()->nama; ?></td>
										<td>
											<?php if ($item->status_dospem_2 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($item->status_dospem_2 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td>
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3<?= $item->id; ?>">Lihat Detail</button>
										</td>
										<td>
											<?php if ($item->status_dospem_1 == 'Diterima' && $item->status_dospem_2 == 'Ditolak') { ?>
												<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal4<?= $item->id; ?>">Terima</button>
											<?php } else { ?>
												<form action="<?= base_url('title/accTitle'); ?>" method="post">
													<input type="hidden" id="id" name="id" value="<?= $item->id; ?>">
													<button type="submit" class="btn btn-primary">Terima</button>
												</form>
											<?php } ?>
											<form action="<?= base_url('title/deTitle'); ?>" method="post">
												<input type="hidden" id="id" name="id" value="<?= $item->id; ?>">
												<button type="submit" class="btn btn-danger">Tolak</button>
											</form>
										</td>
									</tr>

									<!-- Modal Detail Status -->
									<div class="modal fade" id="myModal3<?= $item->id; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Detail</h4>
												</div>
												<div class="modal-body">
													<div class="row">
														<span class="col-sm-5"><b>Judul</b></span>
														<span class="col-sm-10"><?= $item->judul; ?></span>
													</div>
													<div class="row">
														<span class="col-sm-5"><b>Mahasiswa</b></span>
														<span class="col-sm-10"><?= $this->db->where('id', $item->mahasiswa)->get('users')->row()->nama; ?></span>
													</div>
													<hr />
													<div class="row">
														<span class="col-sm-5"><b>Pembimbing 1</b></span>
														<span class="col-sm-10"><?= $this->db->where('id', $item->dospem_1_id)->get('users')->row()->nama; ?></span>
														<br />
														<span>
															<?php if ($item->status_dospem_1 == "Diterima") { ?>
																<span class="badge rounded-pill bg-success">Diterima</span>
															<?php } else if ($item->status_dospem_1 == "Ditolak") { ?>
																<span class="badge rounded-pill bg-danger">Ditolak</span>
															<?php } else { ?>
																<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
															<?php } ?>
														</span>
													</div>
													<div class="row">
														<span class="col-sm-5"><b>Keterangan</b></span>
														<span class="col-sm-10"><?= $item->alasan_dospem_1; ?></span>
													</div>
													<hr />
													<div class="row">
														<span class="col-sm-5"><b>Pembimbing 2</b></span>
														<span class="col-sm-10"><?= $this->db->where('id', $item->dospem_2_id)->get('users')->row()->nama; ?></span>
														<br />
														<span>
															<?php if ($item->status_dospem_1 == "Diterima") { ?>
																<span class="badge rounded-pill bg-success">Diterima</span>
															<?php } else if ($item->status_dospem_1 == "Ditolak") { ?>
																<span class="badge rounded-pill bg-danger">Ditolak</span>
															<?php } else { ?>
																<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
															<?php } ?>
														</span>
													</div>
													<div class="row">
														<span class="col-sm-5"><b>Keterangan</b></span>
														<span class="col-sm-10"><?= $item->alasan_dospem_2; ?></span>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
												</div>
											</div>
										</div>
									</div>

									<!-- Modal Diterima Tapi Ganti Pembimbing 2 -->
									<div class="modal fade" id="myModal4<?= $item->id; ?>" tabindex="-1">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Pilih Dosen Pembimbing 2 Baru</h4>
												</div>
												<div class="modal-body">
													<form class="row g-3 needs-validation border-top" action="<?= base_url('title/accTitle2'); ?>" method="post" novalidate>
														<input type="hidden" id="id" name="id" value="<?= $item->id; ?>">
														<div class="col-12">
															<label for="title_id" class="form-label">Dosen Pembimbing 2</label>
															<select class="form-select" name="dospem2" id="dospem2" aria-label="Default select example">
																<option selected="">-- Pilih Dosen --</option>
																<?php foreach ($dosen as $dosen2) : ?>
																	<option value="<?= $dosen2['id_dosen']; ?>" <?= set_select('dospem_2_id', $dosen2['id_dosen']); ?>><?= $dosen2['nama_dosen']; ?></option>
																<?php endforeach; ?>
															</select>
														</div>
														<div class="col-12 mt-3" align="center">
															<button class="btn btn-primary" style="border-radius: 15px;" type="submit">Terima</button>
														</div>
													</form>
												</div>
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

				<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
					<?php if (empty($t)) { ?>
						<p>Belum ada judul.</p>
					<?php } else { ?>
						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">Pembimbing 1</th>
									<th scope="col">Pembimbing 2</th>
									<th scope="col">Status Akhir</th>
									<th scope="col">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($t as $item) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $item->judul; ?></td>
										<td><?= $item->nama_mahasiswa; ?></td>
										<td><?= $this->db->where('id', $item->dospem_1_id)->get('users')->row()->nama; ?>
											<br />
											<?php if ($item->status_dospem_1 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($item->status_dospem_1 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td><?= $this->db->where('id', $item->dospem_2_id)->get('users')->row()->nama; ?>
											<br />
											<?php if ($item->status_dospem_2 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($item->status_dospem_2 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td>
											<?php if ($item->status_dospem_1 == "Sedang diproses" || $item->status_dospem_2 == "Sedang diproses") { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } else { ?>
												<?php if ($item->status == "Diterima") { ?>
													<span class="badge rounded-pill bg-success">Diterima</span>
												<?php } else if ($item->status == "Ditolak") { ?>
													<span class="badge rounded-pill bg-danger">Ditolak</span>
												<?php } else { ?>
													<span class="badge rounded-pill bg-info">Menunggu Verifikasi</span>
												<?php } ?>
											<?php } ?>
										</td>
										<td>
											<a class="btn btn-primary" href="<?= base_url() ?>title/edit_title/<?= $item->id; ?>">Sunting</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } ?>
				</div>

			</div>
		</div>
	</div>
</section>
