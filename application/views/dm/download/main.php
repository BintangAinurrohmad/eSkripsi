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
					foreach ($downloads as $download) { ?>
						<tr>
							<th scope="row"><?= $no++; ?></th>
							<td><?= $download->name; ?></td>
							<td>
								<a type="submit" class="btn btn-primary" href="<?= base_url() ?>/file/downloads/<?= $download->file_name; ?>">Unduh</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
	</div>
</section>
