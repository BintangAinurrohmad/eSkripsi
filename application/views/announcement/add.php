<section class="section">
	<div class="card">
		<div class="card-body pt-3">

			<form class="row g-3" method="post" action="<?= base_url('announcement/submit') ?>">
				<div class="col-12">
					<label class="form-label">Judul</label>
					<input type="text" name="title" class="form-control" id="inputNanme4" placeholder="Masukkan Judul Pengumuman" required>
				</div>

				<div class="col-12">
					<label class="form-label">Isi</label>
					<textarea class="form-control" name="content" rows="10" placeholder="Masukkan Isi Pengumuman" required></textarea>
				</div>

				<div class="text-center">
					<button type="submit" class="btn btn-primary">Kirim</button>
				</div>
			</form>

		</div>
	</div>
</section>