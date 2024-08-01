<section class="section">
	<div class="card">
		<div class="card-body">

			<?php if (empty($all)) { ?>
				<p>Maaf, Belum Ada Ujian Yang Dijadwalkan.</p>
			<?php } else { ?>

				<table class="table mt-3">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Judul</th>
							<th scope="col">Mahasiswa</th>
							<th scope="col">Pembimbing 1</th>
							<th scope="col">Pembimbing 2</th>
							<th scope="col">Penguji 1</th>
							<th scope="col">Penguji 2</th>
							<th scope="col">Ruang</th>
							<th scope="col">Tanggal</th>
							<th scope="col">Jam</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($all as $all) { ?>
							<tr>
								<th scope="row"><?= $no++; ?></th>
								<td><?= $all->judul; ?></td>
								<td><?php
										$mahasiswa = $this->db->where('id', $all->mahasiswa)->get('users')->row();
										echo $mahasiswa->nama;
										?></td>
								<td><?php
										$dospem1 = $this->db->where('id', $all->dospem_1_id)->get('users')->row();
										echo $dospem1->nama;
										?></td>
								<td><?php
										$dospem2 = $this->db->where('id', $all->dospem_2_id)->get('users')->row();
										echo $dospem2->nama;
										?></td>
								<td><?php
										$dosuji1 = $this->db->where('id', $all->dosuji_1_id)->get('users')->row();
										echo $dosuji1->nama;
										?></td>
								<td><?php
										$dosuji2 = $this->db->where('id', $all->dosuji_2_id)->get('users')->row();
										echo $dosuji2->nama;
										?></td>
								<td><?php
										$room = $this->db->where('id', $all->room_id)->get('rooms')->row();
										echo $room->nama;
										?></td>
								<td><?= $all->tanggal; ?></td>
								<td><?= $all->jam; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

			<?php } ?>



			<!-- Default Table -->

			<!-- End Default Table Example -->
		</div>
	</div>
</section>
