<section class="section">
	<div class="card">
		<div class="card-body pt-3">

			<!-- Alert untuk Success -->
			<?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-info alert-dismissible fade show" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<!-- Alert untuk Error -->
			<?php if ($this->session->flashdata('error')) : ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?php echo $this->session->flashdata('error'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<?php if (empty($ujian)) { ?>
				<p class="mt-3">Maaf, Belum Ada Ujian Yang Dijadwalkan.</p>
			<?php } else { ?>
				<table class="table datatable">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Judul</th>
							<th scope="col">Mahasiswa</th>
							<th scope="col">Dosen Pembimbing 1</th>
							<th scope="col">Dosen Pembimbing 2</th>
							<th scope="col">Dosen Penguji 1</th>
							<th scope="col">Dosen Penguji 2</th>
							<th scope="col">Tanggal ujian</th>
							<th scope="col">Ruang</th>
							<th scope="col">Jam</th>
							<th scope="col">Nilai Akhir</th>
							<th scope="col">Status Ujian</th>
							<th scope="col">Lembar Penilaian</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($ujian as $uj) { ?>
							<tr>
								<th scope="row"><?= $no++; ?></th>
								<td><?= $uj->judul; ?></td>
								<td>
									<?= $this->db->select('nama')->where('id', $uj->mahasiswa)->get('users')->row()->nama; ?>
								</td>
								<td>
									<?= $this->db->select('nama')->where('id', $uj->dospem_1_id)->get('users')->row()->nama; ?>
								</td>
								<td>
									<?= $this->db->select('nama')->where('id', $uj->dospem_2_id)->get('users')->row()->nama; ?>
								</td>
								<td>
									<?= $this->db->select('nama')->where('id', $uj->dosuji_1_id)->get('users')->row()->nama; ?>
								</td>
								<td>
									<?= $this->db->select('nama')->where('id', $uj->dosuji_2_id)->get('users')->row()->nama; ?>
								</td>
								<td><?= format_tgl($uj->tanggal); ?></td>
								<td>
									<?= $this->db->select('nama')->where('id', $uj->room_id)->get('rooms')->row()->nama; ?>
								</td>
								<td><?= $uj->jam; ?></td>
								<td>
									<span class="editable" data-skp_id="<?= $uj->skp_id; ?>"><?= $uj->nilai; ?></span>
									<form method="post" action="<?= site_url('score_skripsi/update_nilai'); ?>" class="edit-form" style="display: none;">
										<input type="hidden" name="skp_id" value="<?= $uj->skp_id; ?>">
										<input type="number" name="value" class="edit-input form-control" value="<?= $uj->nilai; ?>">
									</form>
								</td>
								<td>
									<form method="post" action="<?= site_url('score_skripsi/update_status'); ?>" class="status-form">
										<input type="hidden" name="title_id" value="<?= $uj->title_id; ?>">
										<select name="status_ujian_skripsi" class="form-select status-dropdown" style="display: none;" data-id="<?= $uj->skp_id; ?>" onchange="this.form.submit();">
											<option value="Lulus" <?= $uj->status_ujian_skripsi == "Lulus" ? 'selected' : ''; ?>>Lulus</option>
											<option value="Tidak Lulus" <?= $uj->status_ujian_skripsi == "Tidak lulus" ? 'selected' : ''; ?>>Tidak Lulus</option>
											<option value="Terdaftar" <?= $uj->status_ujian_skripsi == "Terdaftar" ? 'selected' : ''; ?>>Menunggu Penilaian</option>
											<option value="Belum Daftar" <?= $uj->status_ujian_skripsi == "Belum Daftar" ? 'selected' : ''; ?>>Belum Daftar</option>
										</select>
										<span class="badge rounded-pill <?= $uj->status_ujian_skripsi == 'Lulus' ? 'bg-success' : ($uj->status_ujian_skripsi == 'Tidak lulus' ? 'bg-danger' : ($uj->status_ujian_skripsi == 'Terdaftar' ? 'bg-secondary' : 'bg-warning')); ?> status-badge" data-id="<?= $uj->skp_id; ?>">
											<?= $uj->status_ujian_skripsi; ?>
										</span>
									</form>
								</td>
								<td>
									<a class="btn btn-info" href="<?= base_url() ?>score_skripsi/view_nilai/<?= $uj->skp_id ?>">Lihat</a>
									<a class="btn btn-success" href="<?= base_url() ?>score_skripsi/download_nilai/<?= $uj->skp_id ?>">Unduh</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>
</section>

<!-- Script untuk Edit Nilai -->
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var editables = document.querySelectorAll('.editable');
		editables.forEach(function(editable) {
			editable.addEventListener('click', function() {
				var skp_id = this.dataset.skp_id;
				var form = document.querySelector('form[data-skp_id="' + skp_id + '"]');

				this.style.display = 'none';
				form.style.display = 'block';
				form.querySelector('.edit-input').focus();
			});
		});

		var inputs = document.querySelectorAll('.edit-input');
		inputs.forEach(function(input) {
			input.addEventListener('keypress', function(e) {
				if (e.key === 'Enter') {
					this.form.submit();
				}
			});

			input.addEventListener('blur', function() {
				var skp_id = this.parentNode.dataset.skp_id;
				var editable = document.querySelector('.editable[data-skp_id="' + skp_id + '"]');
				this.parentNode.style.display = 'none';
				editable.style.display = 'block';
			});
		});
	});
</script>

<!-- Script untuk Mengubah Status Ujian -->
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var statusBadges = document.querySelectorAll('.status-badge');

		statusBadges.forEach(function(badge) {
			badge.addEventListener('click', function() {
				var id = this.dataset.id;
				var dropdown = document.querySelector('.status-dropdown[data-id="' + id + '"]');

				this.style.display = 'none';
				dropdown.style.display = 'block';
			});
		});

		var statusDropdowns = document.querySelectorAll('.status-dropdown');

		statusDropdowns.forEach(function(dropdown) {
			dropdown.addEventListener('blur', function() {
				this.style.display = 'none';
				var id = this.dataset.id;
				var badge = document.querySelector('.status-badge[data-id="' + id + '"]');
				badge.style.display = 'block';
			});
		});
	});
</script>