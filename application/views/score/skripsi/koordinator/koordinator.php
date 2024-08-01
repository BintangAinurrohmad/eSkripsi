<section class="section">
	<div class="card">
		<div class="card-body pt-3">
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
							<th scope="col">Status Ujian</th>
							<th scope="col">Nilai Akhir</th>
							<th scope="col">Lembar Penilaian</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($ujian as $uj) { ?>
							<tr>
								<th scope="row"><?= $no; ?></th>
								<td><?php echo $uj->judul; ?></td>
								<td>
									<?php
									$mhs = $this->db->where('id', $uj->mahasiswa)->get('users')->row();
									echo $mhs->nama;
									?>
								</td>
								<td>
									<?php
									$dospem1 = $this->db->where('id', $uj->dospem_1_id)->get('users')->row();
									echo $dospem1->nama;
									?>
								</td>
								<td>
									<?php
									$dospem2 = $this->db->where('id', $uj->dospem_2_id)->get('users')->row();
									echo $dospem2->nama;
									?>
								</td>
								<td>
									<?php
									$dosuji1 = $this->db->where('id', $uj->dosuji_1_id)->get('users')->row();
									echo $dosuji1->nama;
									?>
								</td>
								<td>
									<?php
									$dosuji2 = $this->db->where('id', $uj->dosuji_2_id)->get('users')->row();
									echo $dosuji2->nama;
									?>
								</td>
								<td><?php echo format_tgl($uj->tanggal); ?></td>
								<td>
									<?php
									$room = $this->db->where('id', $uj->room_id)->get('rooms')->row();
									echo $room->nama;
									?>
								</td>
								<td><?php echo $uj->jam; ?></td>
								<td><?php echo $uj->status_ujian_skripsi; ?></td>
								<td>
									<span class="editable" data-skp_id="<?php echo $uj->skp_id; ?>"><?php echo $uj->nilai; ?></span>
									<form method="post" action="<?php echo site_url('score_skripsi/update_nilai'); ?>" class="edit-form" data-skp_id="<?php echo $uj->skp_id; ?>" style="display: none;">
										<input type="hidden" name="skp_id" value="<?php echo $uj->skp_id; ?>">
										<input type="text" name="value" class="edit-input form-control" value="<?php echo $uj->nilai; ?>">
									</form>
								</td>
								<td>
									<a type="submit" class="btn btn-info" href="<?= base_url() ?>score_skripsi/view_nilai/<?= $uj->skp_id ?>">Lihat</a>
									<a type="submit" class="btn btn-success" href="<?= base_url() ?>score_skripsi/download_nilai/<?= $uj->skp_id ?>">Unduh</a>
								</td>
							</tr>
						<?php $no++;
						} ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>
</section>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var editables = document.querySelectorAll('.editable');
		editables.forEach(function(editable) {
			editable.addEventListener('click', function() {
				var skp_id = this.dataset.skp_id;
				var form = document.querySelector('form[data-skp_id="' + skp_id + '"]');
				var input = form.querySelector('.edit-input');

				this.style.display = 'none';
				form.style.display = 'block';
				input.focus();
			});
		});

		var inputs = document.querySelectorAll('.edit-input');
		inputs.forEach(function(input) {
			input.addEventListener('keypress', function(e) {
				if (e.which == 13) {
					this.form.submit();
				}
			});

			input.addEventListener('blur', function() {
				var skp_id = this.parentNode.dataset.skp_id;
				var editable = document.querySelector('.editable[data-skp_id="' + skp_id + '"]');
				var form = this.parentNode;

				form.style.display = 'none';
				editable.style.display = 'block';
			});
		});
	});
</script>
