

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ $title }} | NDFProject</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="{{ asset('img/favicon.ico') }}" rel="icon">   
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <script type="text/javascript">
    window.$crisp = [];
    window.CRISP_WEBSITE_ID = "{{ config('services.crisp.website_id') }}";
    (function() {
      d = document;
      s = d.createElement("script");
      s.src = "https://client.crisp.chat/l.js";
      s.async = 1;
      d.getElementsByTagName("head")[0].appendChild(s);
    })();
  </script>
</head>
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.gtm.id') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', '{{ config('services.gtm.id') }}');
</script>

<body>

  <div id="spinner" class="spinner-wrapper">
    <div class="text-center d-flex">
      <div class="spinner-grow spinner-grow-sm text-info" style="width: 1rem; height: 1rem;" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="text-info ms-2" style="font-family: 'Courier New', Courier, monospace">Loading Assets...</p>
    </div>
  </div>

  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
    <x-header></x-header>
  <main id="main">
   {{ $slot }}
  </main><!-- End #main -->

  <footer id="footer">
    <div class="container">
      <div class=" text-white-50">
        &copy; Copyright <strong><span>NDFProject</span></strong>
      </div>
      <div class="credits">
      </div>
    </div>
  </footer><!-- End  Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- Vendor JS Files -->
  <script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/typed.js/typed.umd.js') }}"></script>
  <script src="{{ asset('vendor/waypoints/noframework.waypoints.js') }}"></script>
     <script src="{{ asset('js/event/event.js') }}"></script>

  <script src="{{ asset('js/main.js') }}"></script>
  <script>
    var tahunSekarang = new Date().getFullYear();
    var tahunKelahiran = 2003;
    var umur = tahunSekarang - tahunKelahiran;
    var umurSpan = document.getElementById("umurSpan");
    umurSpan.textContent = umur;
  </script> 
   <script>
    window.addEventListener('load', function() {
      document.getElementById('spinner').style.display = 'none';
    });
  </script>

</body>

</html>