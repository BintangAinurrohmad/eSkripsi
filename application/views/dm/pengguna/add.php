<section class="section">
	<div class="card">
		<div class="card-body">

			<?php if ($this->session->flashdata('error')) : ?>
				<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
					<?php echo $this->session->flashdata('error'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<form action="<?php echo base_url('dm/add_user'); ?>" method="post" novalidate>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">NPM/NIDN</label>
					<div class="col-sm-10">
						<input type="number" name="npm" class="form-control" id="npm" placeholder="Masukkan NPM/NIDN" required>
						<?php echo form_error('npm'); ?>
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Nama</label>
					<div class="col-sm-10">
						<input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama" required>
						<?php echo form_error('nama'); ?>
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Email</label>
					<div class="col-sm-10">
						<input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" required>
						<?php echo form_error('email'); ?>
					</div>
				</div>

				<div class="row mb-3 mt-3">
					<label for="inputText" class="col-sm-2 col-form-label">Kata Sandi</label>
					<div class="col-sm-10">
						<input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Kata Sandi" required>
						<?php echo form_error('password'); ?>
					</div>
				</div>

				<div class="row mb-3">
					<label class="col-sm-2 col-form-label">Jenis Pengguna</label>
					<div class="col-sm-10">
						<select class="form-select" name="role" id="role" aria-label="Default select example">
							<option selected="">-- Pilih Jenis Pengguna --</option>
							<?php foreach ($role as $role) : ?>
								<option value="<?= $role['id']; ?>" <?= set_select('bidang_id', $role['id']); ?>><?= $role['nama']; ?></option>
							<?php endforeach; ?>
						</select>
						<?php echo form_error('role'); ?>
					</div>
				</div>

				<div class="row mb-3">
					<label class="col-sm-2 col-form-label">Angkatan</label>
					<div class="col-sm-10">
						<select class="form-select" name="angkatan" id="angkatan" aria-label="Default select example">
							<!-- Isi otomatis menggunaka JavaScript -->
						</select>
						<div class="text-sm text-muted"><i>Masukan tahun angkatan jika yang ditambahkan adalah data mahasiswa.</i></div>
						<?php echo form_error('role'); ?>
					</div>
				</div>

				<div class="col-sm-10" align="center">
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>

			</form>
		</div>
	</div>
</section>

<script>
	const selectTahun = document.getElementById('angkatan');


	const currentYear = new Date().getFullYear();


	const startYear = currentYear - 3;
	const endYear = currentYear - 10;

	for (let year = startYear; year >= endYear; year--) {
		const option = document.createElement('option');
		option.value = year; // Nilai value sesuai dengan tahun
		option.textContent = year;
		selectTahun.appendChild(option);
	}
</script>
