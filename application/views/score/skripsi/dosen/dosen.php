<section class="section">
	<div class="card">
		<div class="card-body">

			<?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
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
					<a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Penguji 1</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab4-tab" data-bs-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Penguji 2</a>
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
						<p>Maaf, Belum Ada Ujian Yang Dijadwalkan.</p>
					<?php } else { ?>

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">Tanggal ujian</th>
									<th scope="col">Ruang</th>
									<th scope="col">Jam</th>
									<th scope="col">Aksi</th>
									<th scope="col">Lembar Penilaian</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($dospem1 as $dospem1) { ?>
									<tr>
										<th scope="row"><?= $no; ?></th>
										<td><?php echo $dospem1->judul; ?></td>
										<td>
											<?php
											$mhs = $this->db->where('id', $dospem1->mahasiswa)->get('users')->row();
											echo $mhs->nama;
											?>
										</td>
										<td><?php echo $dospem1->tanggal; ?></td>
										<td>
											<?php
											$room = $this->db->where('id', $dospem1->room_id)->get('rooms')->row();
											echo $room->nama;
											?>
										</td>
										<td><?php echo $dospem1->jam; ?></td>
										<td>
											<a type="submit" class="btn btn-primary" href="<?= base_url() ?>score_skripsi/nilai_pembimbing/<?= $dospem1->nilai_id ?>">Nilai</a>
										</td>
										<td>
											<a type="submit" class="btn btn-info" href="<?= base_url() ?>score_skripsi/view_nilai/<?= $dospem1->skp_id ?>">Lihat</a>
											<a type="submit" class="btn btn-success" href="<?= base_url() ?>score_skripsi/download_nilai/<?= $dospem1->skp_id ?>">Unduh</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					<?php } ?>

					<!-- End Default Table Example -->
				</div>
			</div>

			<div class="tab-content mt-2">
				<div class="tab-pane fade show" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">

					<!-- <div class="d-flex justify-content mt-3">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                </div> -->

					<?php if (empty($dospem2)) { ?>
						<p>Maaf, Belum Ada Ujian Yang Dijadwalkan.</p>
					<?php } else { ?>

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">Tanggal ujian</th>
									<th scope="col">Ruang</th>
									<th scope="col">Jam</th>
									<th scope="col">Aksi</th>
									<th scope="col">Lembar Penilaian</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($dospem2 as $dospem2) { ?>
									<tr>
										<th scope="row"><?= $no; ?></th>
										<td><?php echo $dospem2->judul; ?></td>
										<td>
											<?php
											$mhs = $this->db->where('id', $dospem2->mahasiswa)->get('users')->row();
											echo $mhs->nama;
											?>
										</td>
										<td><?php echo $dospem2->tanggal; ?></td>
										<td>
											<?php
											$room = $this->db->where('id', $dospem2->room_id)->get('rooms')->row();
											echo $room->nama;
											?>
										</td>
										<td><?php echo $dospem2->jam; ?></td>
										<td>
											<a type="submit" class="btn btn-primary" href="<?= base_url() ?>score_skripsi/nilai_pembimbing/<?= $dospem2->nilai_id ?>">Nilai</a>
										</td>
										<td>
											<a type="submit" class="btn btn-info" href="<?= base_url() ?>score_skripsi/view_nilai/<?= $dospem2->skp_id ?>">Lihat</a>
											<a type="submit" class="btn btn-success" href="<?= base_url() ?>score_skripsi/download_nilai/<?= $dospem2->skp_id ?>">Unduh</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					<?php } ?>
					<!-- End Default Table Example -->
				</div>
			</div>

			<div class="tab-content mt-2">
				<div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">

					<!-- <div class="d-flex justify-content mt-3">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                </div> -->

					<?php if (empty($dosuji1)) { ?>
						<p>Maaf, Belum Ada Ujian Yang Dijadwalkan.</p>
					<?php } else { ?>

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">Tanggal ujian</th>
									<th scope="col">Ruang</th>
									<th scope="col">Jam</th>
									<th scope="col">Aksi</th>
									<th scope="col">Lembar Penilaian</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($dosuji1 as $dosuji1) { ?>
									<tr>
										<th scope="row"><?= $no; ?></th>
										<td><?php echo $dosuji1->judul; ?></td>
										<td>
											<?php
											$mhs = $this->db->where('id', $dosuji1->mahasiswa)->get('users')->row();
											echo $mhs->nama;
											?>
										</td>
										<td><?php echo $dosuji1->tanggal; ?></td>
										<td>
											<?php
											$room = $this->db->where('id', $dosuji1->room_id)->get('rooms')->row();
											echo $room->nama;
											?>
										</td>
										<td><?php echo $dosuji1->jam; ?></td>
										<td>
											<a type="submit" class="btn btn-primary" href="<?= base_url() ?>score_skripsi/nilai_penguji/<?= $dosuji1->nilai_id ?>">Nilai</a>
										</td>
										<td>
											<a type="submit" class="btn btn-info" href="<?= base_url() ?>score_skripsi/view_nilai/<?= $dosuji1->skp_id ?>">Lihat</a>
											<a type="submit" class="btn btn-success" href="<?= base_url() ?>score_skripsi/download_nilai/<?= $dosuji1->skp_id ?>">Unduh</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					<?php } ?>
					<!-- End Default Table Example -->
				</div>
			</div>

			<div class="tab-content mt-2">
				<div class="tab-pane fade show" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">

					<!-- <div class="d-flex justify-content mt-3">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                </div> -->

					<?php if (empty($dosuji2)) { ?>
						<p>Maaf, Belum Ada Ujian Yang Dijadwalkan.</p>
					<?php } else { ?>

						<table class="table datatable">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Judul</th>
									<th scope="col">Mahasiswa</th>
									<th scope="col">Tanggal ujian</th>
									<th scope="col">Ruang</th>
									<th scope="col">Jam</th>
									<th scope="col">Aksi</th>
									<th scope="col">Lembar Penilaian</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($dosuji2 as $dosuji2) { ?>
									<tr>
										<th scope="row"><?= $no; ?></th>
										<td><?php echo $dosuji2->judul; ?></td>
										<td>
											<?php
											$mhs = $this->db->where('id', $dosuji2->mahasiswa)->get('users')->row();
											echo $mhs->nama;
											?>
										</td>
										<td><?php echo $dosuji2->tanggal; ?></td>
										<td>
											<?php
											$room = $this->db->where('id', $dosuji2->room_id)->get('rooms')->row();
											echo $room->nama;
											?>
										</td>
										<td><?php echo $dosuji2->jam; ?></td>
										<td>
											<a type="submit" class="btn btn-primary" href="<?= base_url() ?>score_skripsi/nilai_penguji/<?= $dosuji2->nilai_id ?>">Nilai</a>
										</td>
										<td>
											<a type="submit" class="btn btn-info" href="<?= base_url() ?>score_skripsi/view_nilai/<?= $dosuji2->skp_id ?>">Lihat</a>
											<a type="submit" class="btn btn-success" href="<?= base_url() ?>score_skripsi/download_nilai/<?= $dosuji2->skp_id ?>">Unduh</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>

					<?php } ?>
					<!-- End Default Table Example -->
				</div>
			</div>

		</div>
	</div>
</section>
