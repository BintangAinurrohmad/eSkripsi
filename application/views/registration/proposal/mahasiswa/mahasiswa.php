<section class="section">
	<div class="card">
		<div class="card-body">

			<h5 class="card-title">Ujian Saya</h5>

			<?php if ($this->session->flashdata('success')) : ?>
				<div class="alert alert-info alert-dismissible fade show" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<?php if (empty($myProposal)) { ?>
				<p>Anda belum mendaftar untuk mengikuti ujian proposal.</p>
			<?php } else { ?>

				<table class="table datatable">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Judul</th>
							<th scope="col">Naskah</th>
							<th scope="col">Lembar Persetujuan</th>
							<th scope="col">Pembimbing 1</th>
							<th scope="col">Pembimbing 2</th>
							<th scope="col">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($myProposal as $proposal) { ?>
							<tr>
								<th scope="row"><?= $no++; ?></th>
								<td><?= $proposal->judul; ?></td>
								<td><a class="btn btn-primary" href="<?= base_url() ?>registration_proposal/view_file/naskah/<?= $proposal->file_naskah; ?>">Lihat</a></td>
								<td><a class="btn btn-primary" href="<?= base_url() ?>registration_proposal/view_file/persetujuan/<?= $proposal->file_persetujuan; ?>">Lihat</a></td>
								<td>
									<?php
									$dosen1 = $this->db->where('id', $proposal->dospem_1_id)->get('users')->row();
									echo $dosen1->nama;
									?>
									<br />
									<?php if ($proposal->pro_status_dospem_1 == "Diterima") { ?>
										<span class="badge rounded-pill bg-success">Diterima</span>
									<?php } else if ($proposal->pro_status_dospem_1 == "Ditolak") { ?>
										<span class="badge rounded-pill bg-danger">Ditolak</span>
									<?php } else { ?>
										<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
									<?php } ?>
								</td>
								<td>
									<?php
									$dosen2 = $this->db->where('id', $proposal->dospem_2_id)->get('users')->row();
									echo $dosen2->nama;
									?>
									<br />
									<?php if ($proposal->pro_status_dospem_2 == "Diterima") { ?>
										<span class="badge rounded-pill bg-success">Diterima</span>
									<?php } else if ($proposal->pro_status_dospem_2 == "Ditolak") { ?>
										<span class="badge rounded-pill bg-danger">Ditolak</span>
									<?php } else { ?>
										<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
									<?php } ?>
								</td>
								<td>
									<?php if ($proposal->pro_status_dospem_1 == "Sedang diproses" || $proposal->pro_status_dospem_2 == "Sedang diproses") { ?>
										<span class="badge rounded-pill bg-secondary">Menunggu Persetujuan</span>
									<?php } else { ?>
										<?php if ($proposal->pro_status == "Diterima") { ?>
											<span class="badge rounded-pill bg-success">Diterima</span>
										<?php } else if ($proposal->pro_status == "Ditolak") { ?>
											<span class="badge rounded-pill bg-danger">Ditolak</span>
										<?php } else { ?>
											<span class="badge rounded-pill bg-info">Menunggu Penjadwalan</span>
										<?php } ?>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

			<?php } ?>

			<?php
			// Logika untuk menampilkan tombol tambah
			$showAddButton = true;
			if (is_array($myProposal) && !empty($myProposal)) {
				$latestProposal = $myProposal[0]; // Ambil proposal terbaru
				if ($latestProposal->pro_status == "Sedang diproses") {
					$showAddButton = false;
				} elseif ($latestProposal->pro_status == "Ditolak") {
					$showAddButton = true;
				} else {
					$showAddButton = false;
				}
			} else {
				$showAddButton = true;
			}
			?>

			<?php if ($showAddButton) : ?>
				<a class="btn btn-primary position-absolute top-0 end-0 m-3" href="<?= base_url() ?>registration_proposal/daftar" style="border-radius: 15px;">
					<i class="ri-add-line"></i>
					Tambah
				</a>
			<?php endif; ?>

		</div>
	</div>
</section>
