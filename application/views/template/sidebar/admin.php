<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

	<ul class="sidebar-nav" id="sidebar-nav">

		<li class="nav-item">
			<a class="nav-link <?= set_active('dashboard'); ?>" href="<?= base_url() ?>dashboard/">
				<i class="ri-home-6-fill"></i><span>Dasbor</span>
			</a>
		</li><!-- End Dashboard Nav -->

		<li class="nav-item">
			<a class="nav-link <?= set_active('dm'); ?>" data-bs-target="#data-nav" data-bs-toggle="collapse" href="#">
				<i class="ri-stack-fill"></i><span>Data Master</span><i class="bi bi-chevron-down ms-auto"></i>
			</a>
			<ul id="data-nav" class="nav-content collapse <?= is_dropdown_active(['dm', 'dm/research_area', 'dm/room', 'download']); ?>" data-bs-parent="#sidebar-nav">
				<li>
					<a href="<?= base_url('dm/admin'); ?>" class="<?= set_active_specific(['dm/admin', 'dm/add']); ?>">
						<i class="bi bi-circle"></i><span>Pengguna</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url('dm/research_area'); ?>" class="<?= set_active('dm/research_area'); ?>">
						<i class="bi bi-circle"></i><span>Bidang Penelitian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url('dm/room'); ?>" class="<?= set_active('dm/room'); ?>">
						<i class="bi bi-circle"></i><span>Ruang Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url('download'); ?>" class="<?= set_active('download'); ?>">
						<i class="bi bi-circle"></i><span>Unduhan</span>
					</a>
				</li>
			</ul>
		</li><!-- End Data Master Nav -->

		<li class="nav-item">
			<a class="nav-link <?= set_active('title'); ?>" href="<?= base_url() ?>title/admin">
				<i class="ri-quill-pen-fill"></i><span>Pengajuan Judul</span>
			</a>
		</li><!-- End Title Submission Nav -->

		<li class="nav-item">
			<a class="nav-link <?= set_active('proposal'); ?>" data-bs-target="#proposal-nav" data-bs-toggle="collapse" href="#">
				<i class="ri-book-fill"></i><span>Proposal</span><i class="bi bi-chevron-down ms-auto"></i>
			</a>
			<ul id="proposal-nav" class="nav-content collapse <?= is_dropdown_active(['progress_proposal', 'registration_proposal', 'schedule_proposal', 'score_proposal', 'post_proposal']); ?>" data-bs-parent="#sidebar-nav">
				<li>
					<a href="<?= base_url() ?>progress_proposal/" class="<?= set_active('progress_proposal'); ?>">
						<i class="bi bi-circle"></i><span>Bimbingan</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>registration_proposal/" class="<?= set_active('registration_proposal'); ?>">
						<i class="bi bi-circle"></i><span>Pendaftaran Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>schedule_proposal/" class="<?= set_active('schedule_proposal'); ?>">
						<i class="bi bi-circle"></i><span>Jadwal Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>score_proposal/" class="<?= set_active('score_proposal'); ?>">
						<i class="bi bi-circle"></i><span>Hasil Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>post_proposal/" class="<?= set_active('post_proposal'); ?>">
						<i class="bi bi-circle"></i><span>Pasca Ujian</span>
					</a>
				</li>
			</ul>
		</li><!-- End Proposal Nav -->

		<li class="nav-item">
			<a class="nav-link <?= set_active('skripsi'); ?>" data-bs-target="#skripsi-nav" data-bs-toggle="collapse" href="#">
				<i class="ri-book-line"></i><span>Skripsi</span><i class="bi bi-chevron-down ms-auto"></i>
			</a>
			<ul id="skripsi-nav" class="nav-content collapse <?= is_dropdown_active(['progress_skripsi', 'registration_skripsi', 'schedule_skripsi', 'score_skripsi', 'post_skripsi']); ?>" data-bs-parent="#sidebar-nav">
				<li>
					<a href="<?= base_url() ?>progress_skripsi/" class="<?= set_active('progress_skripsi'); ?>">
						<i class="bi bi-circle"></i><span>Bimbingan</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>registration_skripsi/" class="<?= set_active('registration_skripsi'); ?>">
						<i class="bi bi-circle"></i><span>Pendaftaran Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>schedule_skripsi/" class="<?= set_active('schedule_skripsi'); ?>">
						<i class="bi bi-circle"></i><span>Jadwal Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>score_skripsi/" class="<?= set_active('score_skripsi'); ?>">
						<i class="bi bi-circle"></i><span>Hasil Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>post_skripsi/" class="<?= set_active('post_skripsi'); ?>">
						<i class="bi bi-circle"></i><span>Pasca Ujian</span>
					</a>
				</li>
			</ul>
		</li><!-- End Skripsi Nav -->

	</ul>

</aside><!-- End Sidebar-->