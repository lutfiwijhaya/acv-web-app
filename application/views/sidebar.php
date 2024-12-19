<aside class="main-sidebar sidebar-light-primary elevation-4">
	<a href=# class="brand-link">
		<img src="<?= base_url() ?>assets/admin/dist/img/Logo.png" alt="AdminLTE Logo" class="brand-image img-square elevation-3" style="opacity: .8">
		<span class="fw-bold">ACHIVON</span>
	</a>
	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src=<?= $this->session->userdata('path_foto'); ?> class="img-square elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block"><?= $this->session->userdata('nama'); ?></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
				<a href="<?= base_url('admin'); ?>" class="nav-link <?= ($this->uri->segment(1) == 'admin' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>Dashboard</p>
					</a>
				</li>
				<?php
				$menu = $this->menu_model->getMenus($this->session->userdata('posisi'));
				foreach ($menu->result() as $row) :
					$submenu = $this->menu_model->getSubMenus($this->session->userdata('posisi'), $row->_id);
					if ($submenu->num_rows() > 0) { ?>
						<li class="nav-item has-treeview <?= ($row->title == 'KN Chemichal Plant') ? 'menu-open' : ''; ?>">
							<a href="#" class="nav-link"  >
								<i class="nav-icon <?= $row->icon; ?>"></i>
								<p>
									<?= $row->title; ?>
									<i class="fas fa-angle-left right"></i>
									<!-- <span class="badge badge-info right"><?= $submenu->num_rows(); ?></span> -->
								</p>
							</a>
							<ul class="nav nav-treeview">
								<?php foreach ($submenu->result() as $sub) :
									$submenu2 = $this->menu_model->getSubMenus($this->session->userdata('posisi'), $sub->menu_id);
									$is_sub_active = ($this->uri->uri_string() == $sub->uri) ? 'active' : 'fasde';
									if ($submenu2->num_rows() > 0) { ?>
										<li class="nav-item">
											<a href="#" class="nav-link">
												<i class="<?= $sub->icon; ?> nav-icon"></i>
												<p><?= $sub->title; ?></p>
												
												<i class="fas fa-angle-left right"></i>
											</a>
											<ul class="nav nav-treeview menu-open">
												<?php foreach ($submenu2->result() as $sub2) : ?>
													<li class="nav-item">
														<a href="<?= base_url($sub2->uri); ?>" class="nav-link">
															<i class="<?= $sub2->icon; ?> nav-icon"></i>
															<p><?= $sub2->title; ?></p>
															<!-- <?= ($this->uri->uri_string() == $sub2->uri) ? 'active' : 'fasde' ?> -->
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
										</li>
									<?php }else { ?>
									<li class="nav-item" >
									<a href="<?= base_url($sub->uri); ?>" class="nav-link menu-link" data-title="<?= $sub->menu_id; ?>">
											<i class="<?= $sub->icon; ?> nav-icon"></i>
											<p>
												<?= $sub->title; ?>

												</p>
											
										</a>
									</li>
								<?php }
							 endforeach; ?>
							</ul>
						</li>
					<?php } else { ?>
						<li class="nav-item">
							<a href="<?= base_url('admin/dashboard'); ?>" class="nav-link">
								<i class="nav-icon <?= $row->icon; ?>"></i>
								<p><?= $row->title; ?></p>
							</a>
						</li>
				<?php }
				endforeach; ?>
				<li class="nav-header">USER</li>
				<?php if ($this->session->posisi == 2 || $this->session->posisi == 1 || $this->session->posisi == 6) { ?>
					<?php if ($this->session->posisi == 1 || $this->session->posisi == 6) { ?>
						<!-- <li class="nav-item">
					<a href="<?= base_url() ?>admin/inputtagihan" class="nav-link">
						<i class="nav-icon fa fa-check-double"></i>
						<p>
							Input Penagihan
						</p>
					</a>
				</li> -->
					<?php } else { ?>
						<!-- <li class="nav-item">
					<a href="<?= base_url() ?>admin/penjualanapprove" class="nav-link">
						<i class="nav-icon fa fa-check-double"></i>
						<p>
							Approval Penjualan
							<span class="badge badge-info right">2</span>
						</p>
					</a>
				</li> -->
						<!-- <li class="nav-item">
					<a href="<?= base_url() ?>admin/penagihanapprove" class="nav-link">
						<i class="nav-icon fa fa-check-double"></i>
						<p>
							Approval Penagihan
							<span class="badge badge-info right">2</span>
						</p>
					</a>
				</li> -->
				<?php }
				} ?>
				<li class="nav-item">
					<a href="<?= base_url() ?>admin/logout" class="nav-link">
						<i class="nav-icon fa fa-sign-out-alt"></i>
						<p>
							Logout
						</p>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>


<script type="text/javascript">


$(document).ready(function() {
    // Tangkap event klik pada menu
    // $('.menu-link').on('click', function(e) {
    //     var menuTitle = $(this).data('title'); // Ambil nilai data-title
		
    //     // Kirim nilai menu_title ke backend menggunakan AJAX
    //     $.post("<?= base_url('admin/set_menu_title'); ?>", { menu_title: menuTitle }, function(response) {
    //         alert(response); 
    //     });
    // });

// 	setInterval(function() {
//         // Kirim request ke method ping setiap 10 detik
//         $.ajax({
//             url: '<?= base_url('admin/ping'); ?>',
//             type: 'GET',
//             success: function(response) {
//                 console.log(response); // Tampilkan respon jika perlu
//             },
//             error: function() {
//                 console.error('Error keeping connection alive.');
//             }
//         });
//     }, 15000); // 10.000 milidetik = 10 detik
});
</script>

