<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> {{ $title }} | NDFProject</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
  <link rel="stylesheet" href="{{ asset('css/dash.css') }}" />
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
  <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
  <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
  <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
  <script type="text/javascript">
    window.$crisp = [];
    window.CRISP_WEBSITE_ID = "1e04db0b-6c8c-4e95-a60b-49c6607ff0c3";
    (function() {
      d = document;
      s = d.createElement("script");
      s.src = "https://client.crisp.chat/l.js";
      s.async = 1;
      d.getElementsByTagName("head")[0].appendChild(s);
    })();
  </script>
</head>

<body>
  <!-- Spinner -->
  <div id="spinner" class="spinner-wrapper">
    <div class="text-center">
      <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
  
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
  
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('js/dashjs/sidebarmenu.js') }}"></script>
  <script src="{{ asset('js/dashjs/app.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
  <script>
    // JavaScript to hide the spinner after the page has fully loaded
    window.addEventListener('load', function() {
      document.getElementById('spinner').style.display = 'none';
    });
  </script>
</body>

</html>