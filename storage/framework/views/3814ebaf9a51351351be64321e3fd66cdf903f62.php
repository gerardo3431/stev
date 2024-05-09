<!DOCTYPE html>
  <HTML lang="es">
<!--
Template Name: NobleUI - Laravel Admin Dashboard Template
Author: NobleUI
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
Purchase: https://1.envato.market/nobleui_laravel
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html>
<head>
  <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive Laravel Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, laravel, theme, front-end, ui kit, web">

  <title>StevLab</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->
  
  <!-- CSRF Token -->
  <meta name="_token" content="<?php echo e(csrf_token()); ?>">
  
  <link rel="shortcut icon" href="<?php echo e(asset('public/favicon.ico')); ?>">

  <!-- plugin css -->
  <link href="<?php echo e(asset('public/assets/fonts/feather-font/css/iconfont.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('public/assets/plugins/flag-icon-css/css/flag-icon.min.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('public/assets/plugins/perfect-scrollbar/perfect-scrollbar.css')); ?>" rel="stylesheet" />
  <!-- end plugin css -->

  <?php echo $__env->yieldPushContent('plugin-styles'); ?>

  <!-- common css -->
  <link href="<?php echo e(asset('public/css/app.css')); ?>" rel="stylesheet" />
  <!-- end common css -->

  <?php echo $__env->yieldPushContent('style'); ?>
</head>
<body class="sidebar-dark " data-base-url="<?php echo e(url('/')); ?>">

  <script src="<?php echo e(asset('public/assets/js/spinner.js')); ?>"></script>

  <div class="main-wrapper" id="app">
    <?php echo $__env->make('layout.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="page-wrapper">
      <?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="page-content">
        <?php echo $__env->yieldContent('content'); ?>
        
      </div>
      <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
  </div>

    <!-- base js -->
    <script src="<?php echo e(asset('public/js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/feather-icons/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')); ?>"></script>
    <!-- end base js -->

    <!-- plugin js -->
    <?php echo $__env->yieldPushContent('plugin-scripts'); ?>
    <!-- end plugin js -->

    <!-- common js -->
    <script src="<?php echo e(asset('public/assets/js/template.js')); ?>"></script>
    <!-- end common js -->

    <?php echo $__env->yieldPushContent('custom-scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\laboratorios\resources\views/layout/master.blade.php ENDPATH**/ ?>