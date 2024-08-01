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

			<form method="post" action="<?php echo base_url('profile/edit_my_profile'); ?>">

				<h5 class="card-title mt-3">Informasi Pribadi</h5>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Nama</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nama" id="nama" value="<?= $myProfile->nama ?>" required oninvalid="this.setCustomValidity('Nama Tidak Boleh Kosong')" oninput="this.setCustomValidity('')">
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">
						<?php
						if ($this->session->userdata('group_id') == 1) {
							echo "NPM";
						} else if ($this->session->userdata('group_id') == 2) {
							echo "NIDN";
						} else if ($this->session->userdata('group_id') == 3) {
							echo "NIDN";
						} else if ($this->session->userdata('group_id') == 4) {
							echo "ID Admin";
						} else {
							echo "ID Penyusup";
						}
						?>
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="npm" id="npm" value="<?= $myProfile->npm ?>" required oninvalid="this.setCustomValidity('NPM Tidak Boleh Kosong')" oninput="this.setCustomValidity('')">
					</div>
				</div>

				<?php if($this->session->userdata('group_id') == 1) { ?>
				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Angkatan</label>
					<div class="col-sm-10">
						<select class="form-control" id="angkatan" name="angkatan">
							<!-- Pilihan tahun akan dihasilkan secara dinamis menggunakan JavaScript -->
						</select>
					</div>
				</div>
				<?php } ?>

				<script>
					const selectTahun = document.getElementById('angkatan');

					const currentYear = new Date().getFullYear();
					const startYear = currentYear - 3 ;
					const endYear = currentYear - 10;
					const angkatan = <?php echo $myProfile->angkatan; ?>;

					for (let year = startYear; year >= endYear; year--) {
						const option = document.createElement('option');
						option.value = year;
						option.textContent = year;

						if (year === angkatan) {
							option.selected = true;
						}

						selectTahun.appendChild(option);
					}
				</script>

				<div class="row mb-3 mt-3">
					<label class="col-sm-2 col-form-label">Jenis Kelamin</label>
					<div class="col-sm-10">
						<select class="form-select" name="jenis_kelamin" id="jenis_kelamin" aria-label="Default select example">
							<option value="L" <?php if ($myProfile->jenis_kelamin == "L") {
													echo "selected";
												} ?>>Laki-Laki</option>
							<option value="P" <?php if ($myProfile->jenis_kelamin == "P") {
													echo "selected";
												} ?>>Perempuan</option>
						</select>
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Alamat</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="alamat" id="alamat" value="<?= $myProfile->alamat ?>">
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Tempat Lahir</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="<?= $myProfile->tempat_lahir ?>">
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Tanggal Lahir</label>
					<div class="col-sm-10">
						<input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" value="<?= $myProfile->tgl_lahir ?>">
					</div>
				</div>

				<h5 class="card-title">Informasi Kontak</h5>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Email</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="email" id="email" value="<?= $myProfile->email ?>" required oninvalid="this.setCustomValidity('Email Tidak Boleh Kosong')" oninput="this.setCustomValidity('')">
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Telepon</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="telepon" id="telepon" value="<?= $myProfile->telepon ?>">
					</div>
				</div>

				<div class="col-sm-10" align="center">
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
			<hr />

			<h5 class="card-title">Ubah Kata Sandi</h5>

			<form method="post" action="<?php echo base_url('profile/edit_my_password'); ?>">

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Kata Sandi Lama</label>
					<div class="col-sm-10">
						<input type="password" placeholder="Masukkan Kata Sandi Lama" class="form-control" name="old_password" id="old_password" required oninvalid="this.setCustomValidity('Kolom Tidak Boleh Kosong')" oninput="this.setCustomValidity('')">
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Kata Sandi Baru</label>
					<div class="col-sm-10">
						<input type="password" placeholder="Masukkan Kata Sandi Baru" class="form-control" name="new_password" id="new_password" required oninvalid="this.setCustomValidity('Kolom Tidak Boleh Kosong')" oninput="this.setCustomValidity('')">
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Ulangi Kata Sandi Baru</label>
					<div class="col-sm-10">
						<input type="password" placeholder="Masukkan Ulang Kata Sandi Baru" class="form-control" name="confirm_password" id="confirm_password" required oninvalid="this.setCustomValidity('Kolom Tidak Boleh Kosong')" oninput="this.setCustomValidity('')">
					</div>
				</div>

				<div class="col-sm-10" align="center">
					<button type="submit" class="btn btn-primary">Ubah</button>
				</div>

			</form>

		</div>
	</div>
</section>
