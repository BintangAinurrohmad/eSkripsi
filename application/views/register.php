<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>eSkripsi - Daftar</title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Favicons -->
	<link href="<?= base_url() ?>template/assets/img/favicon.png" rel="icon">
	<link href="<?= base_url() ?>template/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

	<!-- Google Fonts -->
	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url() ?>template/assets/font/Poppins-Regular.ttf">

	<!-- Vendor CSS Files -->
	<link href="<?= base_url() ?>template/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>template/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="<?= base_url() ?>template/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>template/assets/vendor/quill/quill.snow.css" rel="stylesheet">
	<link href="<?= base_url() ?>template/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
	<link href="<?= base_url() ?>template/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
	<link href="<?= base_url() ?>template/assets/vendor/simple-datatables/style.css" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="<?= base_url() ?>template/assets/css/style.css" rel="stylesheet">
	<style>
		body {
			font-family: 'CustomFont', sans-serif;
		}
	</style>

</head>

<body style="background-color: #9AB1B9;">

	<main>
		<div class="container">

			<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

							<div class="card mb-3" style="border-radius: 15px;">

								<div class="card-body">

									<div class="d-flex justify-content-center py-4">
										<a href="<?= base_url() ?>" class="logo d-flex align-items-center w-auto">
											<img src="<?= base_url() ?>template/assets/img/logoeskripsi.png" alt="">
										</a>
									</div>

									<?php if ($this->session->flashdata('error')) : ?>
										<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
											<?php echo $this->session->flashdata('error'); ?>
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
									<?php endif; ?>

									<form class="row g-3 needs-validation border-top" action="<?php echo base_url('register/register_user'); ?>" method="post" novalidate>

										<div class="col-12">
											<label for="npm" class="form-label">NPM</label>
											<div class="input-group has-validation">
												<input type="text" name="npm" class="form-control" id="npm" placeholder="Masukkan NPM" required>
												<?php echo form_error('npm'); ?>
											</div>
										</div>

										<div class="col-12">
											<label for="nama" class="form-label">Nama Lengkap</label>
											<div class="input-group has-validation">
												<input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama Lengkap" required>
												<?php echo form_error('nama'); ?>
											</div>
										</div>

										<div class="col-12">
											<label for="nama" class="form-label">Angkatan</label>
											<div class="input-group has-validation">
												<select class="form-control" id="angkatan" name="angkatan">
													<!-- Pilihan tahun akan dihasilkan secara dinamis menggunakan JavaScript -->
												</select>
												<?php echo form_error('angkatan'); ?>
											</div>
										</div>

										<div class="col-12">
											<label for="email" class="form-label">Email</label>
											<div class="input-group has-validation">
												<input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" required>
												<?php echo form_error('email'); ?>
											</div>
										</div>

										<div class="col-12">
											<label for="password" class="form-label">Kata Sandi</label>
											<input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Kata Sandi" required>
											<?php echo form_error('password'); ?>
										</div>

										<!--
                    <div class="col-12">
                      <label for="rePassword" class="form-label">Ulangi Kata Sandi</label>
                      <input type="password" name="rePassword" class="form-control" id="rePassword" placeholder="Masukkan Ulang Kata Sandi" required>
                    </div>
                    -->

										<div class="col-12" align="center">
											<button class="btn btn-primary" style="border-radius: 15px;" type="submit">Daftar</button>
										</div>

									</form>

									<br />

									<div class="col-12" align="center">
										<p class="small mb-0">Sudah punya akun? <a href="<?= base_url() ?>">masuk di sini.</a></p>
									</div>

								</div>
							</div>

						</div>
					</div>
				</div>

			</section>

		</div>
	</main><!-- End #main -->

	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

	<!-- Vendor JS Files -->
	<script src="<?= base_url() ?>template/assets/vendor/apexcharts/apexcharts.min.js"></script>
	<script src="<?= base_url() ?>template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>template/assets/vendor/chart.js/chart.umd.js"></script>
	<script src="<?= base_url() ?>template/assets/vendor/echarts/echarts.min.js"></script>
	<script src="<?= base_url() ?>template/assets/vendor/quill/quill.min.js"></script>
	<script src="<?= base_url() ?>template/assets/vendor/simple-datatables/simple-datatables.js"></script>
	<script src="<?= base_url() ?>template/assets/vendor/tinymce/tinymce.min.js"></script>
	<script src="<?= base_url() ?>template/assets/vendor/php-email-form/validate.js"></script>

	<!-- Template Main JS File -->
	<script src="<?= base_url() ?>template/assets/js/main.js"></script>

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

</body>

</html>
