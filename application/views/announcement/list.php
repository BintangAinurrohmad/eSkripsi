<section class="section">
	<div class="card">
		<div class="card-body">

			<?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-info alert-dismissible fade show" style="margin-top: 4rem;" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>


			<!-- <div class="d-flex justify-content mt-3">
						<form class="d-flex">
							<input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
							<button class="btn btn-outline-primary" type="submit">
								<i class="ri-search-line"></i>
							</button>
						</form>
					</div> -->

			<table class="table" style="margin-top: 4rem;">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Tanggal</th>
						<th scope="col">Judul</th>
						<th scope="col">Penulis</th>
						<th scope="col">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1;
					foreach ($pengumuman as $pengumuman) { ?>
						<tr>
							<th scope="row"><?= $no++; ?></th>
							<td><?= $pengumuman->tanggal; ?></td>
							<td><?= $pengumuman->judul; ?></td>
							<td><?= $pengumuman->isi; ?></td>
							<td>
								<a type="submit" class="btn btn-primary" href="<?= base_url() ?>">Sunting</a>
								<a type="submit" class="btn btn-danger" href="<?= base_url() ?>">Hapus</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

			<a class="btn btn-primary position-absolute top-0 end-0 m-3" href="<?= base_url() ?>announcement/add" style="border-radius: 15px;">
				<i class="ri-add-line"></i>
				Tambah
			</a>
		</div>
	</div>
</section>
