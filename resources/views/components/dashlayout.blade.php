<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NDFProject | {{ $title }}</title>
  <link rel="shortcut icon" type="image/png" href="" />
  <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
  <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
  <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
   <x-dashnavbar></x-dashnavbar>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
     <x-dashheader></x-dashheader>
      <!--  Header End -->
      {{ $slot }}
    </div>
  </div>
  <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('vendor/simplebar/dist/simplebar.js') }}"></script>
  <script src="{{ asset('js/dashjs/sidebarmenu.js') }}"></script>
  <script src="{{ asset('js/dashjs/app.min.js') }}"></script>
  <script src="{{ asset('js/dashjs/dashboard.js') }}"></script>
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>