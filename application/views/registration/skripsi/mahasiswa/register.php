<section class="section">
	<div class="card">
		<div class="card-body">

			<?php if ($this->session->flashdata('error')) : ?>
				<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
					<?php echo $this->session->flashdata('error'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<form method="post" action="<?php echo base_url('registration_skripsi/addSkripsi'); ?>" enctype="multipart/form-data">

				<input type="hidden" value="<?= $myTitle->id ?>" name="title_id" id="title_id">
				<div class="row mb-3 mt-3">
					<label class="col-sm-2 col-form-label">Judul</label>
					<div class="col-sm-10">
						<input class="form form-control" type="text" value="<?= $myTitle->judul ?>" disabled>
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label class="col-sm-2 col-form-label">Naskah Skripsi</label>
					<div class="col-sm-10">
						<input type="file" class="form-control" name="file_naskah" id="file_naskah" placeholder="Pilih File">
					</div>
					<div class="text-sm text-muted">* .pdf dengan ukuran maksimal 5MB</div>
				</div>

				<div class="row mb-3 mt-3">
					<label class="col-sm-2 col-form-label">Bukti Pembayaran</label>
					<div class="col-sm-10">
						<input type="file" class="form-control" name="file_ukt" id="file_ukt" placeholder="Pilih File">
					</div>
					<div class="text-sm text-muted">* .pdf dengan ukuran maksimal 2MB</div>
				</div>

				<div class="row mb-3 mt-3">
					<label class="col-sm-2 col-form-label">Transkrip Nilai</label>
					<div class="col-sm-10">
						<input type="file" class="form-control" name="file_transkrip" id="file_transkrip" placeholder="Pilih File">
					</div>
					<div class="text-sm text-muted">* .pdf dengan ukuran maksimal 2MB</div>
				</div>

				<div class="row mb-3 mt-3">
					<label class="col-sm-2 col-form-label">Lembar Persetujuan</label>
					<div class="col-sm-10">
						<input type="file" class="form-control" name="file_persetujuan" id="file_persetujuan" placeholder="Pilih File">
					</div>
					<div class="text-sm text-muted">* .pdf dengan ukuran maksimal 2MB</div>
				</div>

				<div class="col-sm-10" align="center">
					<button type="submit" class="btn btn-primary">Daftar</button>
				</div>

			</form>
		</div>
	</div>
</section>
