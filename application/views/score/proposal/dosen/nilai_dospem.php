<section class="section">
	<div class="card">
		<div class="card-body">
			<!-- General Form Elements -->
			<form action="<?= base_url('score_proposal/insert_nilai_pembimbing') ?>" method="post">
				<input type="hidden" name="id" id="id" value="<?= $ujian->nilai_id ?>">
				<div class="row mb-3 mt-3">
					<label for="inputTanggal" class="col-sm-2 col-form-label"><b>Tanggal</b></label>
					<div class="col-sm-10 w-50 mt-2">
						<?= $ujian->tanggal ?>
					</div>
				</div>
				<div class="row mb-3">
					<label for="inputJudul" class="col-sm-2 col-form-label"><b>Judul</b></label>
					<div class="col-sm-10 w-50 mt-2">
						<?= $ujian->judul ?>
					</div>
				</div>
				<div class="row mb-3">
					<label for="inputJudul" class="col-sm-2 col-form-label"><b>Mahasiswa</b></label>
					<div class="col-sm-10 w-50 mt-2">
						<?php
						$mahasiswa = $this->db->where('id', $ujian->mahasiswa)->get('users')->row();
						echo $mahasiswa->nama;
						?>
					</div>
				</div>
				<div class="row mb-3">
					<label for="inputJudul" class="col-sm-2 col-form-label"><b>NPM</b></label>
					<div class="col-sm-10 w-50 mt-2">
						<?php
						echo $mahasiswa->npm;
						?>
					</div>
				</div>
				<hr>
				<table class="table table-borderless w-75">
					<thead>
						<tr>
							<th>A. Penilaian Naskah</th>
							<th>Skor 0-100</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Teknik Penulisan</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->naskah_penulisan ?>" name="naskah_penulisan" id="naskah_penulisan" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>Konsep Pemikiran</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->naskah_pemikiran ?>" name="naskah_pemikiran" id="naskah_pemikiran" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>Kajian Pustaka</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->naskah_kajian ?>" name="naskah_kajian" id="naskah_kajian" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>Metode Penelitian</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->naskah_metode ?>" name="naskah_metode" id="naskah_metode" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>Hasil penelitian</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->naskah_hasil ?>" name="naskah_hasil" id="naskah_penulisan" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>Kesimpulan</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->naskah_kesimpulan ?>" name="naskah_kesimpulan" id="naskah_kesimpulan" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>Kepustakaan</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->naskah_kepustakaan ?>" name="naskah_kepustakaan" id="naskah_kepustakaan" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th>B. Penilaian Pelaksanaan Ujian</th>
							<th>Skor 0-100</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Presentasi</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->pelaksanaan_presentasi ?>" name="pelaksanaan_presentasi" id="pelaksanaan_presentasi" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>Penguasaan Materi</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->pelaksanaan_penguasaan ?>" name="pelaksanaan_penguasaan" id="pelaksanaan_penguasaan" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>

						<tr>
							<td>Kemampuan Berargumentasi</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->pelaksanaan_argumentasi ?>" name="pelaksanaan_argumentasi" id="pelaksanaan_argumentasi" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th>C. Penilaian Pembimbingan</th>
							<th>Skor 0-100</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Ketekunan</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->bimbingan_ketekunan ?>" name="bimbingan_ketekunan" id="bimbingan_ketekunan" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>Adab</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->bimbingan_adab ?>" name="bimbingan_adab" id="bimbingan_adab" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>

						<tr>
							<td>Kemandirian</td>
							<td>
								<div class="col-sm-10">
									<input type="number" value="<?= $ujian->bimbingan_kemandirian ?>" name="bimbingan_kemandirian" id="bimbingan_kemandirian" class="form-control" min="0" max="100" required>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				</body>

				<div class="row mb-3">
					<div class="col-sm-10 mx-auto text-center">
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>

			</form>
			<!-- End General Form Elements -->

		</div>
	</div>
</section>
