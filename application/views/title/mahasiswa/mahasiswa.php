<section class="section">
	<div class="card">
		<div class="card-body">

			<?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-info alert-dismissible fade show" style="margin-top: 4rem;" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<ul class="nav nav-tabs mt-3" id="myTabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Judul Saya</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Semua Judul</a>
				</li>
			</ul>

			<div class="tab-content mt-2">
				<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">

					<?php if (empty($myt)) { ?>
						<p>Anda belum mengajukan judul.</p>
					<?php } else { ?>

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Pembimbing 1</th>
									<th scope="col">Pembimbing 2</th>
									<th scope="col">Status</th>
									<th scope="col">Detail</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($myt as $item) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $item->judul; ?></td>
										<td>
											<?php
											$dosen1 = $this->db->where('id', $item->dospem_1_id)->get('users')->row();
											echo $dosen1->nama;
											?>
										</td>
										<td>
											<?php
											$dosen2 = $this->db->where('id', $item->dospem_2_id)->get('users')->row();
											echo $dosen2->nama;
											?>
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
										<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?= $item->id; ?>">Lihat Detail</button></td>
									</tr>
									<div class="modal fade" id="myModal<?= $item->id; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<!-- Modal Header -->
												<div class="modal-header">
													<h4 class="modal-title">Detail</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<div class="row">
														<span class="col-sm-5"><b>Judul</b></span>
														<span class="col-sm-10"><?= $item->judul; ?></span>
													</div>
													<div class="row">
														<span class="col-sm-5"><b>Mahasiswa</b></span>
														<span class="col-sm-10"><?= $item->nama_mahasiswa; ?></span>
													</div>
													<hr>
													<div class="row">
														<span class="col-sm-5"><b>Pembimbing 1</b></span>
														<span class="col-sm-10">
															<?php
															$dosen1 = $this->db->where('id', $item->dospem_1_id)->get('users')->row();
															echo $dosen1->nama;
															?>
														</span>
														<br />
														<span class="col-sm-10">
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
													<hr>
													<div class="row">
														<span class="col-sm-5"><b>Pembimbing 2</b></span>
														<span class="col-sm-10">
															<?php
															$dosen2 = $this->db->where('id', $item->dospem_2_id)->get('users')->row();
															echo $dosen2->nama;
															?>
														</span>
														<br />
														<span class="col-sm-10">
															<?php if ($item->status_dospem_2 == "Diterima") { ?>
																<span class="badge rounded-pill bg-success">Diterima</span>
															<?php } else if ($item->status_dospem_2 == "Ditolak") { ?>
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
													<hr>
													<div class="row">
														<span class="col-sm-5"><b>Status Akhir</b></span>
														<span class="col-sm-10">
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
														</span>
													</div>
												</div>
												<!-- Modal Footer -->
												<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
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

					<!-- <div class="d-flex justify-content">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                </div> -->

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
									<th scope="col">Status</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($t as $t) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $t->judul; ?></td>
										<td><?= $t->nama_mahasiswa; ?></td>
										<td>
											<?php
											$dosen1 = $this->db->where('id', $t->dospem_1_id)->get('users')->row();
											echo $dosen1->nama;
											?>
											<br />
											<?php if ($t->status_dospem_1 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($t->status_dospem_1 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td>
											<?php
											$dosen2 = $this->db->where('id', $t->dospem_2_id)->get('users')->row();
											echo $dosen2->nama;
											?>
											<br />
											<?php if ($t->status_dospem_2 == "Diterima") { ?>
												<span class="badge rounded-pill bg-success">Diterima</span>
											<?php } else if ($t->status_dospem_2 == "Ditolak") { ?>
												<span class="badge rounded-pill bg-danger">Ditolak</span>
											<?php } else { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } ?>
										</td>
										<td>
											<?php if ($t->status_dospem_1 == "Sedang diproses" || $t->status_dospem_2 == "Sedang diproses") { ?>
												<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
											<?php } else { ?>
												<?php if ($t->status == "Diterima") { ?>
													<span class="badge rounded-pill bg-success">Diterima</span>
												<?php } else if ($t->status == "Ditolak") { ?>
													<span class="badge rounded-pill bg-danger">Ditolak</span>
												<?php } else { ?>
													<span class="badge rounded-pill bg-info">Menunggu Verifikasi</span>
												<?php } ?>
											<?php } ?>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					<?php } ?>

				</div>
			</div>

			<?php
			$showAddButton = true;
			if (is_array($myt) && !empty($myt)) {
				foreach ($myt as $item) {
					if (is_object($item) && isset($item->status)) {
						if ($item->status == "Sedang diproses") {
							$showAddButton = false;
							break;
						}
					}
				}
				if ($showAddButton && $myt[0]->status == "Ditolak") {
					$showAddButton = true;
				} else {
					$showAddButton = false;
				}
			} else {
				$showAddButton = false;
			}
			?>

			<?php if ($showAddButton) : ?>
				<a class="btn btn-primary position-absolute top-0 end-0 m-3" href="<?= base_url() ?>title/mahasiswa2" style="border-radius: 15px;">
					<i class="ri-add-line"></i>
					Tambah
				</a>
			<?php endif; ?>

		</div>
	</div>
</section>
