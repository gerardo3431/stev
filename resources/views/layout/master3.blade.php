<!DOCTYPE html>

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
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

  <!-- plugin css -->
  <link href="{{ asset('public/assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/assets/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('public/assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
  
  <!-- end plugin css -->

  @stack('plugin-styles')

  <!-- common css -->
  <link href="{{ asset('public/css/app.css') }}" rel="stylesheet" />
  <!-- end common css -->

  @stack('style')
</head>
<body class="sidebar-dark" data-base-url="{{url('/')}}">

  <script src="{{ asset('public/assets/js/spinner.js') }}"></script>

  <div class="main-wrapper" id="app">
    @include('layout.sidebar')
    <div class="page-wrapper">
      {{-- @include('layout.header') --}}
      <div class="page-content">
        @yield('content')
      </div>
      @include('layout.footer')
    </div>
  </div>

    <!-- base js -->
    <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <!-- end base js -->

    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    <!-- common js -->
    <script src="{{ asset('public/assets/js/template.js') }}"></script>
    <!-- end common js -->

    @stack('custom-scripts')
</body>
</html>