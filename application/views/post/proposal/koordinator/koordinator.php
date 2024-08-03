<section class="section">
	<div class="card">
		<div class="card-body pt-3">

			<!-- <div class="d-flex justify-content mt-3">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Cari" aria-label="cari">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                </div> -->

			<?php if (empty($pasca)) { ?>
				<p class="mt-3">Belum ada yang mengunggah naskah akhir</p>
			<?php } else { ?>

				<table class="table datatable">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Judul</th>
							<th scope="col">Mahasiswa</th>
							<th scope="col">Pembimbing 1</th>
							<th scope="col">Pembimbing 2</th>
							<th scope="col">Penguji 1</th>
							<th scope="col">Penguji 2</th>
							<th scope="col">Tanggal Pengumpulan</th>
							<th scope="col">Unduh</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($pasca as $data) { ?>
							<tr>
								<th scope="row"><?= $no++; ?></th>
								<td><?= $data->judul; ?></td>
								<td>
									<?php
									$mahasiswa = $this->db->where('id', $data->mahasiswa)->get('users')->row();
									echo $mahasiswa->nama;
									?>
								</td>
								<td>
									<?php
									$dospem1 = $this->db->where('id', $data->dospem_1_id)->get('users')->row();
									echo $dospem1->nama;
									?>
								</td>
								<td>
									<?php
									$dospem2 = $this->db->where('id', $data->dospem_2_id)->get('users')->row();
									echo $dospem2->nama;
									?>
								</td>
								<td>
									<?php
									$dosuji1 = $this->db->where('id', $data->dosuji_1_id)->get('users')->row();
									echo $dosuji1->nama;
									?>
								</td>
								<td>
									<?php
									$dosuji1 = $this->db->where('id', $data->dosuji_2_id)->get('users')->row();
									echo $dosuji1->nama;
									?>
								</td>
								<td><?= $data->tanggal_upload; ?></td>
								<td>
									<a href="<?= base_url(); ?>file/proposal/naskah_final/<?= $data->file_naskah; ?>" class="btn btn-primary" href="">Naskah</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

			<?php } ?>
			<!-- End Default Table Example -->

		</div>
	</div>
</section>