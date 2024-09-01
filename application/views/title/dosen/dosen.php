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
				<li class="nav-item">
					<a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Riwayat</a>
				</li>
			</ul>

			<div class="tab-content mt-2">
				<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">

					<?php if (empty($dospem1)) { ?>
						<p>Tidak ada judul yang menunggu persetujuan.</p>
					<?php } else { ?>

						<!-- <div class="d-flex justify-content mt-3">
							<form class="d-flex">
								<input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
								<button class="btn btn-outline-primary" type="submit">
									<i class="ri-search-line"></i>
								</button>
							</form>
						</div> -->

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Bidang</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">NPM</th>
									<th scope="col">Tanggal Diajukan</th>
									<th scope="col">Detail</th>
									<th scope="col">Aksi</th>
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
											$bidang = $this->db->where('id', $dospem1->bidang_id)->get('research_area')->row();
											echo $bidang->nama;
											?>
										</td>
										<td>
											<?php
											$mahasiswa = $this->db->where('id', $dospem1->mahasiswa)->get('users')->row();
											echo $mahasiswa->nama;
											?>
										</td>
										<td>
											<?php
											$npm = $this->db->where('id', $dospem1->mahasiswa)->get('users')->row();
											echo $npm->npm;
											?>
										</td>
										<td><?= format_tgl($dospem1->tanggal_pengajuan); ?></td>
										<td>
											<!-- Tombol untuk menampilkan detail modal -->
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3<?= $dospem1->id; ?>" onclick="checkPlagiarism('<?= $dospem1->judul ?>', '<?= $dospem1->id ?>')">Detail Status</button>
										</td>
										<td>
											<form action="<?= base_url('title/accDospem1'); ?>" method="post">
												<input type="hidden" id="id" name="id" value="<?= $dospem1->id; ?>"></input>
												<button type="submit" class="btn btn-primary">Terima</button>
											</form>
											<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#myModal<?= $dospem1->id; ?>">Tolak</button>
										</td>
									</tr>
									<div class="modal fade" id="myModal<?= $dospem1->id; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<!-- Modal Header -->
												<div class="modal-header">
													<h4 class="modal-title">Tolak Judul?</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<form action="<?= base_url('title/deDospem1'); ?>" method="post">
														<input type="hidden" id="id" name="id" value="<?= $dospem1->id; ?>"></input>
														<div class="form-floating mb-3">
															<textarea class="form-control" placeholder="Berikan alasan" name="alasan" id="alasan" style="height: 100px;"></textarea>
															<label for="alasan">Alasan</label>
														</div>
														<p align="center"><button type="submit" class="btn btn-danger">Tolak</button></p>
													</form>
												</div>
												<!-- Modal Footer -->
												<div class="modal-footer">
													<button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
												</div>
											</div>
										</div>
									</div>

									<!-- Modal Detail Status -->
									<div class="modal fade" id="myModal3<?= $dospem1->id; ?>">
										<div class="modal-dialog modal-xl">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Detail</h4>
												</div>
												<div class="modal-body modal-body-pdf">
													<div class="row">
														<span class="col-sm-5"><b>Judul</b></span>
														<span class="col-sm-10"><?= $dospem1->judul; ?></span>
													</div>
													<div class="row">
														<span class="col-sm-5"><b>Mahasiswa</b></span>
														<span class="col-sm-10"><?= $this->db->where('id', $dospem1->mahasiswa)->get('users')->row()->nama; ?></span>
													</div>
													<hr />
													<div class="row">
														<span class="col-sm-5"><b>Pembimbing 1</b></span>
														<span class="col-sm-10"><?= $this->db->where('id', $dospem1->dospem_1_id)->get('users')->row()->nama; ?></span>
														<br />
														<span>
															<?php if ($dospem1->status_dospem_1 == "Diterima") { ?>
																<span class="badge rounded-pill bg-success">Diterima</span>
															<?php } else if ($dospem1->status_dospem_1 == "Ditolak") { ?>
																<span class="badge rounded-pill bg-danger">Ditolak</span>
															<?php } else { ?>
																<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
															<?php } ?>
														</span>
													</div>
													<div class="row">
														<span class="col-sm-5"><b>Keterangan</b></span>
														<span class="col-sm-10"><?= $dospem1->alasan_dospem_1; ?></span>
													</div>
													<hr />
													<div class="row">
														<span class="col-sm-5"><b>Pembimbing 2</b></span>
														<span class="col-sm-10"><?= $this->db->where('id', $dospem1->dospem_2_id)->get('users')->row()->nama; ?></span>
														<br />
														<span>
															<?php if ($dospem1->status_dospem_2 == "Diterima") { ?>
																<span class="badge rounded-pill bg-success">Diterima</span>
															<?php } else if ($dospem1->status_dospem_2 == "Ditolak") { ?>
																<span class="badge rounded-pill bg-danger">Ditolak</span>
															<?php } else { ?>
																<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
															<?php } ?>
														</span>
													</div>
													<div class="row">
														<span class="col-sm-5"><b>Keterangan</b></span>
														<span class="col-sm-10"><?= $dospem1->alasan_dospem_2; ?></span>
													</div>
													<div class="row">
														<span class="col-sm-5 mt-3"><b>Status Plagiarisme</b></span>
														<br>
														<div id="plagiarismResult<?= $dospem1->id; ?>" class="mt-3"></div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-success" onclick="printData()">Cetak PDF</button>
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

					<?php if (empty($dospem2)) { ?>
						<p>Tidak ada judul yang menunggu persetujuan.</p>
					<?php } else { ?>

						<!-- <div class="d-flex justify-content mt-3">
							<form class="d-flex">
								<input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
								<button class="btn btn-outline-primary" type="submit">
									<i class="ri-search-line"></i>
								</button>
							</form>
						</div> -->

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Bidang</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">NPM</th>
									<th scope="col">Tanggal Diajukan</th>
									<th scope="col">Detail</th>
									<th scope="col">Aksi</th>
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
											$bidang = $this->db->where('id', $dospem2->bidang_id)->get('research_area')->row();
											echo $bidang->nama;
											?>
										</td>
										<td>
											<?php
											$mahasiswa = $this->db->where('id', $dospem2->mahasiswa)->get('users')->row();
											echo $mahasiswa->nama;
											?>
										</td>
										<td>
											<?php
											$npm = $this->db->where('id', $dospem2->mahasiswa)->get('users')->row();
											echo $npm->npm;
											?>
										</td>
										<td><?= format_tgl($dospem2->tanggal_pengajuan); ?></td>
										<td>
											<!-- Tombol untuk menampilkan detail modal -->
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3<?= $dospem2->id; ?>" onclick="checkPlagiarism('<?= $dospem2->judul ?>', '<?= $dospem2->id ?>')">Detail Status</button>
										</td>
										<td>

											<form action="<?= base_url('title/accDospem2'); ?>" method="post">
												<input type="hidden" id="id" name="id" value="<?= $dospem2->id; ?>"></input>
												<button type="submit" class="btn btn-primary">Terima</button>
											</form>
											<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#myModal2<?= $dospem2->id; ?>">Tolak</button>
										</td>
									</tr>
									<div class="modal fade" id="myModal2<?= $dospem2->id; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<!-- Modal Header -->
												<div class="modal-header">
													<h4 class="modal-title">Tolak Judul?</h4>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<form action="<?= base_url('title/deDospem2'); ?>" method="post">
														<input type="hidden" id="id" name="id" value="<?= $dospem2->id; ?>"></input>
														<div class="form-floating mb-3">
															<textarea class="form-control" placeholder="Berikan alasan" name="alasan" id="alasan" style="height: 100px;"></textarea>
															<label for="alasan">Alasan</label>
														</div>
														<p align="center"><button type="submit" class="btn btn-danger">Tolak</button></p>
													</form>
												</div>
												<!-- Modal Footer -->
												<div class="modal-footer">
													<button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
												</div>
											</div>
										</div>
									</div>

									<!-- Modal Detail Status -->
									<div class="modal fade" id="myModal3<?= $dospem2->id; ?>">
										<div class="modal-dialog modal-xl">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Detail</h4>
												</div>
												<div class="modal-body modal-body-pdf">
													<div class="row">
														<span class="col-sm-5"><b>Judul</b></span>
														<span class="col-sm-10"><?= $dospem2->judul; ?></span>
													</div>
													<div class="row">
														<span class="col-sm-5"><b>Mahasiswa</b></span>
														<span class="col-sm-10"><?= $this->db->where('id', $dospem2->mahasiswa)->get('users')->row()->nama; ?></span>
													</div>
													<hr />
													<div class="row">
														<span class="col-sm-5"><b>Pembimbing 1</b></span>
														<span class="col-sm-10"><?= $this->db->where('id', $dospem2->dospem_1_id)->get('users')->row()->nama; ?></span>
														<br />
														<span>
															<?php if ($dospem2->status_dospem_1 == "Diterima") { ?>
																<span class="badge rounded-pill bg-success">Diterima</span>
															<?php } else if ($dospem2->status_dospem_1 == "Ditolak") { ?>
																<span class="badge rounded-pill bg-danger">Ditolak</span>
															<?php } else { ?>
																<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
															<?php } ?>
														</span>
													</div>
													<div class="row">
														<span class="col-sm-5"><b>Keterangan</b></span>
														<span class="col-sm-10"><?= $dospem2->alasan_dospem_1; ?></span>
													</div>
													<hr />
													<div class="row">
														<span class="col-sm-5"><b>Pembimbing 2</b></span>
														<span class="col-sm-10"><?= $this->db->where('id', $dospem2->dospem_2_id)->get('users')->row()->nama; ?></span>
														<br />
														<span>
															<?php if ($dospem2->status_dospem_2 == "Diterima") { ?>
																<span class="badge rounded-pill bg-success">Diterima</span>
															<?php } else if ($dospem2->status_dospem_2 == "Ditolak") { ?>
																<span class="badge rounded-pill bg-danger">Ditolak</span>
															<?php } else { ?>
																<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
															<?php } ?>
														</span>
													</div>
													<div class="row">
														<span class="col-sm-5"><b>Keterangan</b></span>
														<span class="col-sm-10"><?= $dospem2->alasan_dospem_2; ?></span>
													</div>
													<div class="row">
														<span class="col-sm-5 mt-3"><b>Status Plagiarisme</b></span>
														<br>
														<div id="plagiarismResult<?= $dospem2->id; ?>" class="mt-3"></div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-success" onclick="printData()">Cetak PDF</button>
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

				<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">

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
									<th scope="col">Status Akhir</th>
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
											?> <br />
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
											?> <br />
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
		</div>
	</div>
</section>


<script>
	function checkPlagiarism(judul, dospemId) {
		const formData = new FormData();
		formData.append('new_title', judul);

		fetch('<?php echo base_url("title_plagiarism/index"); ?>', {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				const plagiarismResult = document.getElementById('plagiarismResult' + dospemId);
				plagiarismResult.innerHTML = ''; // Clear previous results

				if (data.length > 0) {
					data.forEach(result => {
						let colorClass = 'text-success'; // Default color for low similarity

						if (result.similarity > 80) {
							colorClass = 'text-danger'; // High similarity
						} else if (result.similarity > 50) {
							colorClass = 'text-warning'; // Medium similarity
						}

						plagiarismResult.innerHTML += `
                    <div class="card mt-3">
                        <div class="card-body p-0 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6>${result.approved_title}</h6>
                                    <p style="font-size: 12px">${result.nama_mahasiswa}</p>
                                </div>
                                <h5 class="${colorClass}">${result.similarity}%</h>
                            </div>
                        </div>
                    </div>
                `;
					});
				} else {
					plagiarismResult.innerHTML = `
                <div class="card mt-3">
                    <div class="card-body p-0 p-3">
                          <h5 class="text-center text-success"> Tidak ada plagiasi pada judul ini </h5>
                    </div>
                </div>
            `;
				}
			})
			.catch(error => console.error('Error:', error));
	}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
	function printData() {
		const {
			jsPDF
		} = window.jspdf;

		// Atur ukuran halaman PDF (contoh ukuran A4 dalam satuan mm)
		const doc = new jsPDF({
			orientation: 'portrait',
			unit: 'mm',
			format: 'a4'
		});

		const content = document.querySelector('.modal-body-pdf');

		html2canvas(content, {
			scale: 2 // Skala lebih tinggi untuk meningkatkan resolusi
		}).then(canvas => {
			// Menghitung dimensi untuk menyesuaikan skala dengan halaman PDF
			const imgWidth = 210; // Lebar A4 (210mm)
			const imgHeight = (canvas.height * imgWidth) / canvas.width; // Mengatur tinggi sesuai dengan proporsi kanvas

			const imgData = canvas.toDataURL('image/png');
			doc.addImage(imgData, 'JPEG', 0, 0, imgWidth, imgHeight, null, 'FAST'); // Menggunakan 'FAST' untuk kualitas yang lebih rendah

			// Simpan PDF
			doc.save('detail-skripsi.pdf');
		});
	};
</script>