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
					<a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Mahasiswa</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Dosen</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Koordinator</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tab4-tab" data-bs-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Admin</a>
				</li>
			</ul>

			<!-- Tab Mahasiswa -->
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

					<table class="table datatable">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">NPM</th>
								<th scope="col">Angkatan</th>
								<th scope="col">Nama</th>
								<th scope="col">Email</th>
								<th scope="col">Telepon</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($mahasiswa as $mahasiswa) { ?>
								<tr>
									<th scope="row"><?= $no++; ?></th>
									<td><?= $mahasiswa->npm; ?></td>
									<td><?= $mahasiswa->angkatan; ?></td>
									<td><?= $mahasiswa->nama; ?></td>
									<td><?= $mahasiswa->email; ?></td>
									<td><?= $mahasiswa->telepon; ?></td>
									<td>
										<a type="submit" class="btn btn-success" href="<?= base_url() ?>dm/reset_password/<?= $mahasiswa->id; ?>">Reset Password</a>
										<a type="submit" class="btn btn-primary" href="<?= base_url() ?>dm/edit_user/<?= $mahasiswa->id; ?>">Sunting</a>
										<a type="submit" class="btn btn-danger" href="<?= base_url() ?>dm/delete_user/<?= $mahasiswa->id; ?>">Hapus</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-content mt-2">
				<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">

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
								<th scope="col">NIDN</th>
								<th scope="col">Nama</th>
								<th scope="col">Email</th>
								<th scope="col">Telepon</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($dosen as $dosen) { ?>
								<tr>
									<th scope="row"><?= $no++; ?></th>
									<td><?= $dosen->npm; ?></td>
									<td><?= $dosen->nama; ?></td>
									<td><?= $dosen->email; ?></td>
									<td><?= $dosen->telepon; ?></td>
									<td>
										<a type="submit" class="btn btn-success" href="<?= base_url() ?>dm/reset_password/<?= $dosen->id; ?>">Reset Password</a>
										<a type="submit" class="btn btn-primary" href="<?= base_url() ?>dm/edit_user/<?= $dosen->id; ?>">Sunting</a>
										<a type="submit" class="btn btn-danger" href="<?= base_url() ?>dm/delete_user/<?= $dosen->id; ?>">Hapus</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-content mt-2">
				<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">

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
								<th scope="col">NIDN</th>
								<th scope="col">Nama</th>
								<th scope="col">Email</th>
								<th scope="col">Telepon</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($koordinator as $koordinator) { ?>
								<tr>
									<th scope="row"><?= $no++; ?></th>
									<td><?= $koordinator->npm; ?></td>
									<td><?= $koordinator->nama; ?></td>
									<td><?= $koordinator->email; ?></td>
									<td><?= $koordinator->telepon; ?></td>
									<td>
										<a type="submit" class="btn btn-success" href="<?= base_url() ?>dm/reset_password/<?= $koordinator->id; ?>">Reset Password</a>
										<a type="submit" class="btn btn-primary" href="<?= base_url() ?>dm/edit_user/<?= $koordinator->id; ?>">Sunting</a>
										<a type="submit" class="btn btn-danger" href="<?= base_url() ?>dm/delete_user/<?= $koordinator->id; ?>">Hapus</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-content mt-2">
				<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">

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
								<th scope="col">NIDN</th>
								<th scope="col">Nama</th>
								<th scope="col">Email</th>
								<th scope="col">Telepon</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($admin as $admin) { ?>
								<tr>
									<th scope="row"><?= $no++; ?></th>
									<td><?= $admin->npm; ?></td>
									<td><?= $admin->nama; ?></td>
									<td><?= $admin->email; ?></td>
									<td><?= $admin->telepon; ?></td>
									<td>
										<a type="submit" class="btn btn-success" href="<?= base_url() ?>dm/reset_password/<?= $admin->id; ?>">Reset Password</a>
										<a type="submit" class="btn btn-primary" href="<?= base_url() ?>dm/edit_user/<?= $admin->id; ?>">Sunting</a>
										<a type="submit" class="btn btn-danger" href="<?= base_url() ?>dm/delete_user/<?= $admin->id; ?>">Hapus</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<a class="btn btn-primary position-absolute top-0 end-0 m-3" href="<?= base_url() ?>dm/add" style="border-radius: 15px;">
				<i class="ri-add-line"></i>
				Tambah
			</a>
		</div>
	</div>
</section>
