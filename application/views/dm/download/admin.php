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
								<a type="submit" class="btn btn-danger" href="<?= base_url('download/delete_file') ?>/<?= $download->id; ?>">Hapus</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>


			<h5 class="card-title">Tambah File Unduhan</h5>


			<form method="post" action="<?= base_url('download/upload_file') ?>" enctype="multipart/form-data">
				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Nama</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="name" id="name" placeholder="Masukkan Nama Berkas Unduhan" required oninvalid="this.setCustomValidity('Kolom Ini Tidak Boleh Kosong')" oninput="this.setCustomValidity('')">
					</div>
				</div>
				<div class=" row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Berkas</label>
					<div class="col-sm-10">
						<input type="file" class="form-control" name="file" id="file" placeholder="Silahkan Pilih Berkas" required oninvalid="this.setCustomValidity('Kolom Ini Tidak Boleh Kosong')" oninput="this.setCustomValidity('')">
					</div>
				</div>
				<button class="btn btn-primary" type="submit">Unggah</button>
			</form>

		</div>
	</div>
</section>
