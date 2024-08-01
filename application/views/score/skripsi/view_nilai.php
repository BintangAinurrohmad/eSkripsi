<section class="section">
	<div class="card">
		<div class="card-body">

			<div class="row mb-3 mt-3">
				<label for="inputTanggal" class="col-sm-2 col-form-label"><b>Tanggal</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $now ?>
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>Judul</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $judul ?>
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>Mahasiswa</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $mahasiswa ?>
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>NPM</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $npm ?>
				</div>
			</div>

			<hr />

			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>Dosen Pembimbing 1</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $dospem1 ?>
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>NIDN</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $dospem1_nidn ?>
				</div>
			</div>
			<h5 class="card-title">Nilai Ujian</h5>
			<table class="table table-striped">
				<thead>
					<tr class="table-primary">
						<th>Aspek Penilaian</th>
						<th>Bobot (B)</th>
						<th>Skor (S)</th>
						<th>B x S</th>
					</tr>
					</th>
					<tr class="table-primary">
						<th>A. Naskah</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Teknik Penulisan</td>
						<td>15</td>
						<td>
							<?= $naskah_penulisan_1 ?>
						</td>
						<td>
							<?= $bs_naskah_penulisan_1 ?>
						</td>
					</tr>
					<tr>
						<td>Konsep Pemikiran</td>
						<td>15</td>
						<td>
							<?= $naskah_pemikiran_1 ?>
						</td>
						<td>
							<?= $bs_naskah_pemikiran_1 ?>
						</td>
					</tr>
					<tr>
						<td>Kajian Pustaka</td>
						<td>15</td>
						<td>
							<?= $naskah_kajian_1 ?>
						</td>
						<td>
							<?= $bs_naskah_kajian_1 ?>
						</td>
					</tr>
					<tr>
						<td>Metode Penelitian</td>
						<td>
							15
						</td>
						<td>
							<?= $naskah_metode_1 ?>
						</td>
						<td>
							<?= $bs_naskah_metode_1 ?>
						</td>
					</tr>
					<tr>
						<td>Hasil penelitian</td>
						<td>20</td>
						<td>
							<?= $naskah_hasil_1 ?>
						</td>
						<td>
							<?= $bs_naskah_hasil_1 ?>
						</td>
					</tr>
					<tr>
						<td>Kesimpulan</td>
						<td>10</td>
						<td>
							<?= $naskah_kesimpulan_1 ?>
						</td>
						<td>
							<?= $bs_naskah_kesimpulan_1 ?>
						</td>
					</tr>
					<tr>
						<td>Kepustakaan</td>
						<td>10</td>
						<td>
							<?= $naskah_kepustakaan_1 ?>
						</td>
						<td>
							<?= $bs_naskah_kepustakaan_1 ?>
						</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td></td>
						<td></td>
						<th><?= $total_a_1 ?></th>
					</tr>
					<tr>
						<th>Rata-Rata A</th>
						<td></td>
						<td></td>
						<th><?= $rata_a_1 ?></th>
					</tr>
				</tbody>
				<thead>
					<tr class="table-primary">
						<th>B.Pelaksanaan Ujian</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Presentasi</td>
						<td>20</td>
						<td>
							<?= $pelaksanaan_presentasi_1 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_presentasi_1 ?>
						</td>
					</tr>
					<tr>
						<td>Penguasaan Materi</td>
						<td>50</td>
						<td>
							<?= $pelaksanaan_penguasaan_1 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_penguasaan_1 ?>
						</td>
					</tr>
					<tr>
						<td>Kemampuan Berargumentasi</td>
						<td>30</td>
						<td>
							<?= $pelaksanaan_argumentasi_1 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_argumentasi_1 ?>
						</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td></td>
						<td></td>
						<th><?= $total_b_1 ?></th>
					</tr>
					<tr>
						<th>Rata-Rata B</th>
						<td></td>
						<td></td>
						<th><?= $rata_b_1 ?></th>
					</tr>
				</tbody>
			</table>
			<h5 class="card-title">Nilai Pembimbingan</h5>
			<table class="table table-striped">
				<thead>
					<tr class="table-primary">
						<th>Aspek</th>
						<th>Skor</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Ketekunan</td>
						<td>
							<?= $bimbingan_ketekunan_1 ?>
						</td>
					</tr>
					<tr>
						<td>Adab</td>
						<td>
							<?= $bimbingan_adab_1 ?>
						</td>
					</tr>
					<tr>
						<td>Kemandirian</td>
						<td>
							<?= $bimbingan_kemandirian_1 ?>
						</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<th><?= $total_c_1 ?></th>
					</tr>
					<tr>
						<th>Rata-Rata</th>
						<th><?= $rata_c_1 ?></th>
					</tr>
				</tbody>
			</table>

			<hr />

			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>Dosen Pembimbing 2</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $dospem2 ?>
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>NIDN</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $dospem2_nidn ?>
				</div>
			</div>
			<h5 class="card-title">Nilai Ujian</h5>
			<table class="table table-striped">
				<thead>
					<tr class="table-primary">
						<th>Aspek Penilaian</th>
						<th>Bobot (B)</th>
						<th>Skor (S)</th>
						<th>B x S</th>
					</tr>
					</th>
					<tr class="table-primary">
						<th>A. Naskah</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Teknik Penulisan</td>
						<td>15</td>
						<td>
							<?= $naskah_penulisan_2 ?>
						</td>
						<td>
							<?= $bs_naskah_penulisan_2 ?>
						</td>
					</tr>
					<tr>
						<td>Konsep Pemikiran</td>
						<td>15</td>
						<td>
							<?= $naskah_pemikiran_2 ?>
						</td>
						<td>
							<?= $bs_naskah_pemikiran_2 ?>
						</td>
					</tr>
					<tr>
						<td>Kajian Pustaka</td>
						<td>15</td>
						<td>
							<?= $naskah_kajian_2 ?>
						</td>
						<td>
							<?= $bs_naskah_kajian_2 ?>
						</td>
					</tr>
					<tr>
						<td>Metode Penelitian</td>
						<td>
							15
						</td>
						<td>
							<?= $naskah_metode_2 ?>
						</td>
						<td>
							<?= $bs_naskah_metode_2 ?>
						</td>
					</tr>
					<tr>
						<td>Hasil penelitian</td>
						<td>20</td>
						<td>
							<?= $naskah_hasil_2 ?>
						</td>
						<td>
							<?= $bs_naskah_hasil_2 ?>
						</td>
					</tr>
					<tr>
						<td>Kesimpulan</td>
						<td>10</td>
						<td>
							<?= $naskah_kesimpulan_2 ?>
						</td>
						<td>
							<?= $bs_naskah_kesimpulan_2 ?>
						</td>
					</tr>
					<tr>
						<td>Kepustakaan</td>
						<td>10</td>
						<td>
							<?= $naskah_kepustakaan_2 ?>
						</td>
						<td>
							<?= $bs_naskah_kepustakaan_2 ?>
						</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td></td>
						<td></td>
						<th><?= $total_a_2 ?></th>
					</tr>
					<tr>
						<th>Rata-Rata A</th>
						<td></td>
						<td></td>
						<th><?= $rata_a_2 ?></th>
					</tr>
				</tbody>
				<thead>
					<tr class="table-primary">
						<th>B.Pelaksanaan Ujian</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Presentasi</td>
						<td>20</td>
						<td>
							<?= $pelaksanaan_presentasi_2 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_presentasi_2 ?>
						</td>
					</tr>
					<tr>
						<td>Penguasaan Materi</td>
						<td>50</td>
						<td>
							<?= $pelaksanaan_penguasaan_2 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_penguasaan_2 ?>
						</td>
					</tr>
					<tr>
						<td>Kemampuan Berargumentasi</td>
						<td>30</td>
						<td>
							<?= $pelaksanaan_argumentasi_2 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_argumentasi_2 ?>
						</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td></td>
						<td></td>
						<th><?= $total_b_2 ?></th>
					</tr>
					<tr>
						<th>Rata-Rata B</th>
						<td></td>
						<td></td>
						<th><?= $rata_b_2 ?></th>
					</tr>
				</tbody>
			</table>
			<h5 class="card-title">Nilai Pembimbingan</h5>
			<table class="table table-striped">
				<thead>
					<tr class="table-primary">
						<th>Aspek</th>
						<th>Skor</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Ketekunan</td>
						<td>
							<?= $bimbingan_ketekunan_2 ?>
						</td>
					</tr>
					<tr>
						<td>Adab</td>
						<td>
							<?= $bimbingan_adab_2 ?>
						</td>
					</tr>
					<tr>
						<td>Kemandirian</td>
						<td>
							<?= $bimbingan_kemandirian_2 ?>
						</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<th><?= $total_c_2 ?></th>
					</tr>
					<tr>
						<th>Rata-Rata</th>
						<th><?= $rata_c_2 ?></th>
					</tr>
				</tbody>
			</table>

			<hr />

			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>Dosen Penguji 1</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $dosuji1 ?>
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>NIDN</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $dosuji1_nidn ?>
				</div>
			</div>
			<h5 class="card-title">Nilai Ujian</h5>
			<table class="table table-striped">
				<thead>
					<tr class="table-primary">
						<th>Aspek Penilaian</th>
						<th>Bobot (B)</th>
						<th>Skor (S)</th>
						<th>B x S</th>
					</tr>
					</th>
					<tr class="table-primary">
						<th>A. Naskah</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Teknik Penulisan</td>
						<td>15</td>
						<td>
							<?= $naskah_penulisan_3 ?>
						</td>
						<td>
							<?= $bs_naskah_penulisan_3 ?>
						</td>
					</tr>
					<tr>
						<td>Konsep Pemikiran</td>
						<td>15</td>
						<td>
							<?= $naskah_pemikiran_3 ?>
						</td>
						<td>
							<?= $bs_naskah_pemikiran_3 ?>
						</td>
					</tr>
					<tr>
						<td>Kajian Pustaka</td>
						<td>15</td>
						<td>
							<?= $naskah_kajian_3 ?>
						</td>
						<td>
							<?= $bs_naskah_kajian_3 ?>
						</td>
					</tr>
					<tr>
						<td>Metode Penelitian</td>
						<td>
							15
						</td>
						<td>
							<?= $naskah_metode_3 ?>
						</td>
						<td>
							<?= $bs_naskah_metode_3 ?>
						</td>
					</tr>
					<tr>
						<td>Hasil penelitian</td>
						<td>20</td>
						<td>
							<?= $naskah_hasil_3 ?>
						</td>
						<td>
							<?= $bs_naskah_hasil_3 ?>
						</td>
					</tr>
					<tr>
						<td>Kesimpulan</td>
						<td>10</td>
						<td>
							<?= $naskah_kesimpulan_3 ?>
						</td>
						<td>
							<?= $bs_naskah_kesimpulan_3 ?>
						</td>
					</tr>
					<tr>
						<td>Kepustakaan</td>
						<td>10</td>
						<td>
							<?= $naskah_kepustakaan_3 ?>
						</td>
						<td>
							<?= $bs_naskah_kepustakaan_3 ?>
						</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td></td>
						<td></td>
						<th><?= $total_a_3 ?></th>
					</tr>
					<tr>
						<th>Rata-Rata A</th>
						<td></td>
						<td></td>
						<th><?= $rata_a_3 ?></th>
					</tr>
				</tbody>
				<thead>
					<tr class="table-primary">
						<th>B.Pelaksanaan Ujian</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Presentasi</td>
						<td>20</td>
						<td>
							<?= $pelaksanaan_presentasi_3 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_presentasi_3 ?>
						</td>
					</tr>
					<tr>
						<td>Penguasaan Materi</td>
						<td>50</td>
						<td>
							<?= $pelaksanaan_penguasaan_3 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_penguasaan_3 ?>
						</td>
					</tr>
					<tr>
						<td>Kemampuan Berargumentasi</td>
						<td>30</td>
						<td>
							<?= $pelaksanaan_argumentasi_3 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_argumentasi_3 ?>
						</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td></td>
						<td></td>
						<th><?= $total_b_3 ?></th>
					</tr>
					<tr>
						<th>Rata-Rata B</th>
						<td></td>
						<td></td>
						<th><?= $rata_b_3 ?></th>
					</tr>
				</tbody>
			</table>

			<hr />

			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>Dosen Penguji 2</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $dosuji2 ?>
				</div>
			</div>
			<div class="row mb-3">
				<label for="inputJudul" class="col-sm-2 col-form-label"><b>NIDN</b></label>
				<div class="col-sm-10 w-50 mt-2">
					<?= $dosuji2_nidn ?>
				</div>
			</div>
			<h5 class="card-title">Nilai Ujian</h5>
			<table class="table table-striped">
				<thead>
					<tr class="table-primary">
						<th>Aspek Penilaian</th>
						<th>Bobot (B)</th>
						<th>Skor (S)</th>
						<th>B x S</th>
					</tr>
					</th>
					<tr class="table-primary">
						<th>A. Naskah</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Teknik Penulisan</td>
						<td>15</td>
						<td>
							<?= $naskah_penulisan_4 ?>
						</td>
						<td>
							<?= $bs_naskah_penulisan_4 ?>
						</td>
					</tr>
					<tr>
						<td>Konsep Pemikiran</td>
						<td>15</td>
						<td>
							<?= $naskah_pemikiran_4 ?>
						</td>
						<td>
							<?= $bs_naskah_pemikiran_4 ?>
						</td>
					</tr>
					<tr>
						<td>Kajian Pustaka</td>
						<td>15</td>
						<td>
							<?= $naskah_kajian_4 ?>
						</td>
						<td>
							<?= $bs_naskah_kajian_4 ?>
						</td>
					</tr>
					<tr>
						<td>Metode Penelitian</td>
						<td>
							15
						</td>
						<td>
							<?= $naskah_metode_4 ?>
						</td>
						<td>
							<?= $bs_naskah_metode_4 ?>
						</td>
					</tr>
					<tr>
						<td>Hasil penelitian</td>
						<td>20</td>
						<td>
							<?= $naskah_hasil_4 ?>
						</td>
						<td>
							<?= $bs_naskah_hasil_4 ?>
						</td>
					</tr>
					<tr>
						<td>Kesimpulan</td>
						<td>10</td>
						<td>
							<?= $naskah_kesimpulan_4 ?>
						</td>
						<td>
							<?= $bs_naskah_kesimpulan_4 ?>
						</td>
					</tr>
					<tr>
						<td>Kepustakaan</td>
						<td>10</td>
						<td>
							<?= $naskah_kepustakaan_4 ?>
						</td>
						<td>
							<?= $bs_naskah_kepustakaan_4 ?>
						</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td></td>
						<td></td>
						<th><?= $total_a_4 ?></th>
					</tr>
					<tr>
						<th>Rata-Rata A</th>
						<td></td>
						<td></td>
						<th><?= $rata_a_4 ?></th>
					</tr>
				</tbody>
				<thead>
					<tr class="table-primary">
						<th>B.Pelaksanaan Ujian</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Presentasi</td>
						<td>20</td>
						<td>
							<?= $pelaksanaan_presentasi_4 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_presentasi_4 ?>
						</td>
					</tr>
					<tr>
						<td>Penguasaan Materi</td>
						<td>50</td>
						<td>
							<?= $pelaksanaan_penguasaan_4 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_penguasaan_4 ?>
						</td>
					</tr>
					<tr>
						<td>Kemampuan Berargumentasi</td>
						<td>30</td>
						<td>
							<?= $pelaksanaan_argumentasi_4 ?>
						</td>
						<td>
							<?= $bs_pelaksanaan_argumentasi_4 ?>
						</td>
					</tr>
					<tr>
						<th>Jumlah</th>
						<td></td>
						<td></td>
						<th><?= $total_b_4 ?></th>
					</tr>
					<tr>
						<th>Rata-Rata B</th>
						<td></td>
						<td></td>
						<th><?= $rata_b_4 ?></th>
					</tr>
				</tbody>
			</table>

			<hr />

			<h5 class="card-title">Rekapitulasi Nilai Gabungan</h5>

			<table class="table table-striped">
				<thead>
					<tr class="table-primary">
						<th>Komponen Penilaian</th>
						<th>Rata-Rata Skor Pembimbing</th>
						<th>Rata-Rata Skor Penguji</th>
						<th>Bobot</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Pembimbingan</td>
						<td><?= $rata_bimbingan_dospem ?></td>
						<td></td>
						<td>20</td>
						<td><?= $bs_rata_bimbingan ?></td>
					</tr>
					<tr>
						<td>Naskah</td>
						<td><?= $rata_naskah_dospem ?></td>
						<td><?= $rata_naskah_dosuji ?></td>
						<td>30</td>
						<td><?= $bs_rata_naskah ?></td>
					</tr>
					<tr>
						<td>Pelaksanaan Ujian</td>
						<td><?= $rata_pelaksanaan_dospem ?></td>
						<td><?= $rata_pelaksanaan_dosuji ?></td>
						<td>50</td>
						<td><?= $bs_rata_pelaksanaan ?></td>
					</tr>
					<tr>
						<th colspan="4">Skor Total</th>
						<th><?= $skor_total ?></th>
					</tr>
					<tr>
						<th colspan="4">Skor Akhir</th>
						<th><?= $skor_akhir ?></th>
					</tr>
					<tr>
						<th colspan="4">Nilai Akhir</th>
						<th><?= $nilai_akhir ?></th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</section>
