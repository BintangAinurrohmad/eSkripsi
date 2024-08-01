<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

	<div class="d-flex align-items-center">
		<i class="bi bi-list toggle-sidebar-btn"></i>
		<div style="width: 20px;"></div>
		<a href="<?= base_url() ?>" class="logo mr-15">
			<span class="d-none d-lg-block"><img src="<?= base_url() ?>template/assets/img/logoeskripsi.png" alt=""></span>
		</a>
	</div><!-- End Logo -->

	<nav class="header-nav ms-auto">
		<ul class="d-flex align-items-center">

			<li class="nav-item dropdown">

				<!-- edit bintang -->
				<a class="nav-link nav-icon" href="<?= base_url() ?>Notification/">
					<i class="bi bi-bell"></i>
					<span class="badge rounded-pill bg-primary p-2 ms-2" id="unread-notifications" style="
						position: absolute;
						margin-left: -10px !important;
						height: 25px;
						width: 24px;
						font-size: 10px;
						padding-bottom: 17px !important;
					">0</span>
				</a><!-- End Notification Icon -->

				<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="">
					<li class="dropdown-header">
						You have 4 new notifications
						<a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
					</li>
					<li>
						<hr class="dropdown-divider">
					</li>

					<li class="notification-item">
						<i class="bi bi-exclamation-circle text-warning"></i>
						<div>
							<h4>Lorem Ipsum</h4>
							<p>Quae dolorem earum veritatis oditseno</p>
							<p>30 min. ago</p>
						</div>
					</li>

					<li>
						<hr class="dropdown-divider">
					</li>

					<li class="notification-item">
						<i class="bi bi-x-circle text-danger"></i>
						<div>
							<h4>Atque rerum nesciunt</h4>
							<p>Quae dolorem earum veritatis oditseno</p>
							<p>1 hr. ago</p>
						</div>
					</li>

					<li>
						<hr class="dropdown-divider">
					</li>

					<li class="notification-item">
						<i class="bi bi-check-circle text-success"></i>
						<div>
							<h4>Sit rerum fuga</h4>
							<p>Quae dolorem earum veritatis oditseno</p>
							<p>2 hrs. ago</p>
						</div>
					</li>

					<li>
						<hr class="dropdown-divider">
					</li>

					<li class="notification-item">
						<i class="bi bi-info-circle text-primary"></i>
						<div>
							<h4>Dicta reprehenderit</h4>
							<p>Quae dolorem earum veritatis oditseno</p>
							<p>4 hrs. ago</p>
						</div>
					</li>

					<li>
						<hr class="dropdown-divider">
					</li>
					<li class="dropdown-footer">
						<a href="#">Show all notifications</a>
					</li>

				</ul><!-- End Notification Dropdown Items -->

			</li>

			<li class="nav-item dropdown pe-3">

				<a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
					<img src="<?= base_url() ?>template/assets/img/user-img.png" alt="Profile" class="rounded-circle">
				</a><!-- End Profile Iamge Icon -->

				<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
					<li class="dropdown-header">
						<h6><?= $this->session->userdata('name'); ?></h6>
						<span>
							<?php
							$role = $this->db->where('id', $this->session->userdata('group_id'))->get('group')->row();
							echo $role->nama;
							?>
						</span>
					</li>
					<li>
						<hr class="dropdown-divider">
					</li>

					<li>
						<a class="dropdown-item d-flex align-items-center" href="<?= base_url('profile/my_profile') ?>">
							<i class="bi bi-person"></i>
							<span>Profile Saya</span>
						</a>
					</li>
					<li>
						<hr class="dropdown-divider">
					</li>

					<li>
						<a class="dropdown-item d-flex align-items-center" href="<?= base_url() ?>login/logout">
							<i class="bi bi-box-arrow-right"></i>
							<span>Keluar</span>
						</a>
					</li>

				</ul><!-- End Profile Dropdown Items -->
			</li><!-- End Profile Nav -->

		</ul>
	</nav><!-- End Icons Navigation -->

	<script>
		async function fetchUnreadNotifications() {
			const response = await fetch("<?= base_url() ?>Notification/unread_count");
			const data = await response.json();
			document.getElementById("unread-notifications").textContent = data.unread_count;
		}

		fetchUnreadNotifications();
		setInterval(fetchUnreadNotifications, 60000); // fetch every 1 minute
	</script>



</header><!-- End Header -->