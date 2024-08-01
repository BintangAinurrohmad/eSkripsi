<section class="section">
	<div class="card">
		<div class="card-body pt-3">

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

			<table class="table datatable">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Nama</th>
						<th scope="col">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1;
					foreach ($ra as $ra) { ?>
						<tr>
							<th scope="row"><?= $no++; ?></th>
							<td><?= $ra->nama; ?></td>
							<td>
								<a type="submit" class="btn btn-danger" href="<?= base_url('dm/delete_research_area') ?>/<?= $ra->id; ?>">Hapus</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>


			<h5 class="card-title">Tambah Bidang Penelitian</h5>


			<form method="post" action="<?= base_url('dm/add_research_area') ?>">
				<div class="col-md-12">
					<input type="text" class="form-control" name="ra" id="ra" placeholder="Masukkan Nama Bidang Penelitian">
				</div><br />
				<button class="btn btn-primary" type="submit">Tambah</button>
			</form>

		</div>
	</div>
</section>
