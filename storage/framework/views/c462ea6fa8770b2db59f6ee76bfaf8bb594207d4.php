<nav class="navbar">
	<a href="#" class="sidebar-toggler">
		<i data-feather="menu"></i>
	</a>
	<div class="navbar-content">
		<form class="search-form">
			<div class="input-group">
				
			</div>
		</form>
		<ul class="navbar-nav">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="mdi mdi-reload mt-1" title="Sucursal actual"></i> <span class="ms-1 me-1 d-none d-md-inline-block"><?php echo e($active->sucursal); ?></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="languageDropdown">
					<?php $__currentLoopData = $sucursales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sucursal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<a href="#" onclick="change_sucursal(<?php echo e($sucursal->id); ?>)" class="dropdown-item py-2"><i class="mdi mdi-medical-bag" title="Sucursal" ></i> <span class="ms-1"> <?php echo e($sucursal->sucursal); ?> </span></a>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					
					
					
					
				</a>
				<div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
					<div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
						<p>6 New Notifications</p>
						<a href="javascript:;" class="text-muted">Clear all</a>
					</div>
					<div class="p-1">
						<a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
							<div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
								<i class="icon-sm text-white" data-feather="gift"></i>
							</div>
							<div class="flex-grow-1 me-2">
								<p>New Order Recieved</p>
								<p class="tx-12 text-muted">30 min ago</p>
							</div>	
						</a>
						<a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
							<div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
								<i class="icon-sm text-white" data-feather="alert-circle"></i>
							</div>
							<div class="flex-grow-1 me-2">
								<p>Server Limit Reached!</p>
								<p class="tx-12 text-muted">1 hrs ago</p>
							</div>	
						</a>
						<a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
							<div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
								<img class="wd-30 ht-30 rounded-circle" src="<?php echo e(url('https://via.placeholder.com/30x30')); ?>" alt="userr">
							</div>
							<div class="flex-grow-1 me-2">
								<p>New customer registered</p>
								<p class="tx-12 text-muted">2 sec ago</p>
							</div>	
						</a>
						<a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
							<div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
								<i class="icon-sm text-white" data-feather="layers"></i>
							</div>
							<div class="flex-grow-1 me-2">
								<p>Apps are ready for update</p>
								<p class="tx-12 text-muted">5 hrs ago</p>
							</div>	
						</a>
						<a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
							<div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
								<i class="icon-sm text-white" data-feather="download"></i>
							</div>
							<div class="flex-grow-1 me-2">
								<p>Download completed</p>
								<p class="tx-12 text-muted">6 hrs ago</p>
							</div>	
						</a>
					</div>
					<div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
						<a href="javascript:;">View all</a>
					</div>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img class="wd-30 ht-30 rounded-circle" src="<?php echo e(asset('/public/assets/images/images/LOGOTIPO2.png')); ?>" alt="profile">
				</a>
				<div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
					<div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
						<div class="mb-3">
							<img class="wd-80 ht-80 rounded-circle" src="<?php echo e(asset('/public/assets/images/images/LOGOTIPO2.png')); ?>" alt="">
						</div>
						<div class="text-center">
							<p class="tx-16 fw-bolder"><?php echo e(Auth::user()->name); ?></p>
							<p class="tx-12 text-muted"><?php echo e(Auth::user()->email); ?></p>
						</div>
					</div>
					<ul class="list-unstyled p-1">
						<li class="dropdown-item py-2">
							<a href="<?php echo e(route('profile.show')); ?>" class="text-body ms-0">
								<i class="me-2 icon-md" data-feather="user"></i>
								<span>Perfil</span>
							</a>
						</li>
						<li class="dropdown-item py-2">
							<a href="<?php echo e(route('stevlab.utils.papeleria')); ?>" class="text-body ms-0">
								<i class="me-2 icon-md" data-feather="edit"></i>
								<span>Utilerias</span>
							</a>
						</li>
						<li class="dropdown-item py-2">
							<a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-body ms-0">
								<i class="me-2 icon-md" data-feather="log-out"></i>
								<span>Log Out</span>
							</a>
							<form method="POST" id="logout-form" action="<?php echo e(route('logout')); ?>">
								<?php echo csrf_field(); ?>
							</form>
						</li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</nav>



<?php $__env->startPush('custom-scripts'); ?>
	<script src="<?php echo e(asset('public/stevlab/administracion/change-sucursal.js')); ?>"></script>
<?php $__env->stopPush(); ?><?php /**PATH C:\laragon\www\laboratorios\resources\views/layout/header.blade.php ENDPATH**/ ?>