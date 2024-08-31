<section class="section">
	<div class="card">
		<div class="card-body">

			<?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<?php if ($this->session->flashdata('error')) : ?>
				<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
					<?php echo $this->session->flashdata('error'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<ul class="nav nav-tabs mt-3" id="myTabs">
				<li class="nav-item">
					<a class="nav-link active" id="tab1" data-bs-toggle="tab" href="#content1">Jadwal Saya</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab2" data-bs-toggle="tab" href="#content2">Semua Jadwal</a>
				</li>
				<!-- Tambahkan lebih banyak tab jika diperlukan -->
			</ul>

			<div class="tab-content mt-2">
				<div class="tab-pane fade show active" id="content1">

					<?php if (empty($dsn)) { ?>
						<p>Maaf, Belum Ada Ujian Yang Dijadwalkan.</p>
					<?php } else { ?>

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">Pembimbing 1</th>
									<th scope="col">Pembimbing 2</th>
									<th scope="col">Penguji 1</th>
									<th scope="col">Penguji 2</th>
									<th scope="col">Ruang</th>
									<th scope="col">Tanggal</th>
									<th scope="col">Jam</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($dsn as $dsn) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $dsn->judul; ?></td>
										<td><?php
											$mahasiswa = $this->db->where('id', $dsn->mahasiswa)->get('users')->row();
											echo $mahasiswa->nama;
											?></td>
										<td><?php
											$dospem1 = $this->db->where('id', $dsn->dospem_1_id)->get('users')->row();
											echo $dospem1->nama;
											?></td>
										<td><?php
											$dospem2 = $this->db->where('id', $dsn->dospem_2_id)->get('users')->row();
											echo $dospem2->nama;
											?></td>
										<td><?php
											$dosuji1 = $this->db->where('id', $dsn->dosuji_1_id)->get('users')->row();
											echo $dosuji1->nama;
											?></td>
										<td><?php
											$dosuji2 = $this->db->where('id', $dsn->dosuji_2_id)->get('users')->row();
											echo $dosuji2->nama;
											?></td>
										<td><?php
											$room = $this->db->where('id', $dsn->room_id)->get('rooms')->row();
											echo $room->nama;
											?></td>
										<td><?= format_tgl($dsn->tanggal); ?></td>
										<td><?= $dsn->jam; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					<?php } ?>



				</div>
				<div class="tab-pane fade" id="content2">

					<?php if (empty($all)) { ?>
						<p>Maaf, Belum Ada Ujian Yang Dijadwalkan.</p>
					<?php } else { ?>

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">Pembimbing 1</th>
									<th scope="col">Pembimbing 2</th>
									<th scope="col">Penguji 1</th>
									<th scope="col">Penguji 2</th>
									<th scope="col">Ruang</th>
									<th scope="col">Tanggal</th>
									<th scope="col">Jam</th>
									<th scope="col">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($all as $all) { ?>
									<tr>
										<th scope="row"><?= $no++; ?></th>
										<td><?= $all->judul; ?></td>
										<td><?php
											$mahasiswa = $this->db->where('id', $all->mahasiswa)->get('users')->row();
											echo $mahasiswa->nama;
											?></td>
										<td><?php
											$dospem1 = $this->db->where('id', $all->dospem_1_id)->get('users')->row();
											echo $dospem1->nama;
											?></td>
										<td><?php
											$dospem2 = $this->db->where('id', $all->dospem_2_id)->get('users')->row();
											echo $dospem2->nama;
											?></td>
										<td><?php
											$dosuji1 = $this->db->where('id', $all->dosuji_1_id)->get('users')->row();
											echo $dosuji1->nama;
											?></td>
										<td><?php
											$dosuji2 = $this->db->where('id', $all->dosuji_2_id)->get('users')->row();
											echo $dosuji2->nama;
											?></td>
										<td><?php
											$room = $this->db->where('id', $all->room_id)->get('rooms')->row();
											echo $room->nama;
											?></td>
										<td><?= format_tgl($all->tanggal); ?></td>
										<td><?= $all->jam; ?></td>
										<td>
											<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal<?= $all->pro_id; ?>">Edit</button>
										</td>
									</tr>

									<div class="modal fade" id="myModal<?= $all->pro_id; ?>" tabindex="-1">
										<div class="modal-dialog">
											<div class="modal-content">
												<!-- Modal Header -->
												<div class="modal-header">
													<h4 class="modal-title">Atur Jadwal</h4>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<!-- Modal Body -->
												<div class="modal-body">
													<form class="row g-3 needs-validation border-top" action="<?php echo base_url('schedule_proposal/update'); ?>" method="post" novalidate>

														<input type="hidden" id="id" name="id" value="<?= $all->pro_id; ?>"></input>

														<input type="hidden" id="title_id" name="title_id" value="<?= $all->title_id; ?>"></input>

														<div class="col-12">
															<label for="tanggal" class="form-label">Tanggal</label>
															<div class="input-group has-validation">
																<input type="date" value="<?= $all->tanggal; ?>" name="tanggal" class="form-control" id="tanggal" placeholder="Pilih Tanggal" required>
															</div>
														</div>

														<div class="col-12">
															<label for="jam" class="form-label">Jam</label>
															<input type="time" value="<?= $all->jam; ?>" name="jam" class="form-control" id="jam" placeholder="Pilih Jam" required>
														</div>

														<div class="col-12">
															<label for="title_id" class="form-label">Ruangan</label>
															<select class="form-select" name="room_id" id="room_id" aria-label="Default select example">
																<option selected="">-- Pilih Ruangan Ujian --</option>
																<?php foreach ($rooms as $room) : ?>
																	<option value="<?= $room['id']; ?>" <?= set_select('id', $room['id']); ?> <?php if ($room['id'] == $all->room_id) echo 'selected'; ?>><?= $room['nama']; ?></option>
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
				<!-- Tambahkan lebih banyak konten jika diperlukan -->
			</div>



			<!-- Default Table -->

			<!-- End Default Table Example -->
		</div>
	</div>
</section>