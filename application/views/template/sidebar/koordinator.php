<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

	<ul class="sidebar-nav" id="sidebar-nav">

		<li class="nav-item">
			<a class="nav-link <?= set_active('dashboard'); ?>" href="<?= base_url() ?>dashboard/">
				<i class="ri-home-6-fill"></i><span>Dasbor</span>
			</a>
		</li><!-- End Dashboard Nav -->

		<li class="nav-item">
			<a class="nav-link <?= set_active('announcement'); ?>" href="<?= base_url() ?>announcement/">
				<i class="ri-megaphone-fill"></i><span>Pengumuman</span>
			</a>
		</li><!-- End Announcement Nav -->

		<li class="nav-item">
			<a class="nav-link <?= set_active('title'); ?>" href="<?= base_url() ?>title/koordinator">
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
					<a href="<?= base_url() ?>registration_proposal/koordinator" class="<?= set_active('registration_proposal'); ?>">
						<i class="bi bi-circle"></i><span>Pendaftaran Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>schedule_proposal/koordinator" class="<?= set_active('schedule_proposal'); ?>">
						<i class="bi bi-circle"></i><span>Jadwal Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>score_proposal/dosen" class="<?= set_active('score_proposal/dosen'); ?>">
						<i class="bi bi-circle"></i><span>Penilaian Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>score_proposal/koordinator" class="<?= set_active('score_proposal/koordinator'); ?>">
						<i class="bi bi-circle"></i><span>Hasil Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>post_proposal/koordinator" class="<?= set_active('post_proposal'); ?>">
						<i class="bi bi-circle"></i><span>Pasca Ujian</span>
					</a>
				</li>
			</ul>
		</li>

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
					<a href="<?= base_url() ?>registration_skripsi/koordinator" class="<?= set_active('registration_skripsi'); ?>">
						<i class="bi bi-circle"></i><span>Pendaftaran Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>schedule_skripsi/" class="<?= set_active('schedule_skripsi'); ?>">
						<i class="bi bi-circle"></i><span>Jadwal Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>score_skripsi/dosen" class="<?= set_active('score_skripsi/dosen'); ?>">
						<i class="bi bi-circle"></i><span>Penilaian Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>score_skripsi/koordinator" class="<?= set_active('score_skripsi/koordinator'); ?>">
						<i class="bi bi-circle"></i><span>Hasil Ujian</span>
					</a>
				</li>
				<li>
					<a href="<?= base_url() ?>post_skripsi/koordinator" class="<?= set_active('post_skripsi'); ?>">
						<i class="bi bi-circle"></i><span>Pasca Ujian</span>
					</a>
				</li>
			</ul>
		</li>

		<li class="nav-item">
			<a class="nav-link <?= set_active('tracking_mhs/track_mhs'); ?>" href="<?= base_url() ?>tracking_mhs/track_mhs">
				<i class="ri-list-ordered"></i><span>Progress mahasiswa</span>
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link <?= set_active('download'); ?>" href="<?= base_url('download') ?>">
				<i class="ri-download-2-fill"></i><span>Unduhan</span>
			</a>
		</li><!-- End Download Nav -->

	</ul>

</aside><!-- End Sidebar-->