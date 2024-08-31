<section class="section">
	<div class="card">
		<div class="card-body" style="padding-top: 4rem;">

			<?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-info alert-dismissible fade show" role="alert">
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

			<table class="table datatable">
				<thead>
					<tr>
						<th scope="col">Tanggal</th>
						<th scope="col">Penulis</th>
						<th scope="col">Judul</th>
						<th scope="col">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1;
					foreach ($pengumuman as $pengumuman) { ?>
						<tr>
							<td><?= format_tgl($pengumuman->created_at); ?></td>
							<td>
								<?php
								$creator = $this->db->where('id', $pengumuman->created_by)->get('users')->row();
								echo $creator->nama;
								?>
							</td>
							<td><?= $pengumuman->title; ?></td>
							<td>
								<a type="submit" class="btn btn-primary" href="<?= base_url('announcement/edit') ?>/<?= $pengumuman->id; ?>">Edit</a>
								<a type="submit" class="btn btn-danger" href="<?= base_url('announcement/delete') ?>/<?= $pengumuman->id; ?>">Hapus</a>
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