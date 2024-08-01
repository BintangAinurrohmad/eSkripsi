<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= base_url() ?>dashboard">
        <i class="ri-home-6-fill"></i><span>Dasbor</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= base_url() ?>title">
        <i class="ri-quill-pen-fill"></i><span>Pengajuan Judul</span>
      </a>
    </li><!-- End Title Submission Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#proposal-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-book-fill"></i><span>Proposal</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="proposal-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?= base_url() ?>progress_proposal/">
            <i class="bi bi-circle"></i><span>Bimbingan</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url() ?>registration_proposal/">
            <i class="bi bi-circle"></i><span>Daftar Ujian</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url() ?>schedule_proposal/">
            <i class="bi bi-circle"></i><span>Jadwal Ujian</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url() ?>score_proposal/">
            <i class="bi bi-circle"></i><span>Hasil Ujian</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url() ?>post_proposal/">
            <i class="bi bi-circle"></i><span>Pasca Ujian</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#skripsi-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-book-line"></i><span>Skripsi</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="skripsi-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?= base_url() ?>progress_skripsi/">
            <i class="bi bi-circle"></i><span>Bimbingan</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url() ?>registration_skripsi/">
            <i class="bi bi-circle"></i><span>Daftar Ujian</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url() ?>schedule_skripsi/">
            <i class="bi bi-circle"></i><span>Jadwal Ujian</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url() ?>score_skripsi/">
            <i class="bi bi-circle"></i><span>Hasil Ujian</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url() ?>post_skripsi/">
            <i class="bi bi-circle"></i><span>Pasca Ujian</span>
          </a>
        </li>
      </ul>
    </li>

    <!--
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#progress-nav" data-bs-toggle="collapse" href="#">
          <span>Progress</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="progress-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>Proposal</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Skripsi</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#registration-nav" data-bs-toggle="collapse" href="#">
          <span>Pendaftaran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="registration-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= base_url() ?>registration_proposal/">
              <i class="bi bi-circle"></i><span>Proposal</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>registration_skripsi/">
              <i class="bi bi-circle"></i><span>Skripsi</span>
            </a>
          </li>
        </ul>
      </li>

      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#schedule-nav" data-bs-toggle="collapse" href="#">
          <span>Jadwal</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="schedule-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= base_url() ?>schedule_proposal/">
              <i class="bi bi-circle"></i><span>Proposal</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>schedule_skripsi/">
              <i class="bi bi-circle"></i><span>Skripsi</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#exam-nav" data-bs-toggle="collapse" href="#">
          <span>Ujian</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="exam-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= base_url() ?>score_proposal/">
              <i class="bi bi-circle"></i><span>Proposal</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>score_skripsi/">
              <i class="bi bi-circle"></i><span>Skripsi</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#after-nav" data-bs-toggle="collapse" href="#">
          <span>Pasca Ujian</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="after-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= base_url() ?>post_proposal/">
              <i class="bi bi-circle"></i><span>Proposal</span>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>post_skripsi/">
              <i class="bi bi-circle"></i><span>Skripsi</span>
            </a>
          </li>
        </ul>
      </li>
      -->


    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= base_url('download') ?>">
        <i class="ri-download-2-fill"></i><span>Unduhan</span>
      </a>
    </li><!-- End Download Nav -->

  </ul>

</aside><!-- End Sidebar-->