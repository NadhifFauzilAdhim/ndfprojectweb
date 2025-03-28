
<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebSite">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ffffff">
  <!-- Primary Meta Tags -->
  <title>{{ $title ?? 'NDFProject - Web Development & Digital Solutions' }} | NDFProject</title>
  <meta name="title" content="{{ $title ?? 'NDFProject - Web Development & Digital Solutions' }}">
  <meta name="description" content="{{ $description ?? 'Web development services, custom solutions, and digital innovation. Transform your ideas into reality with our expert team.' }}">
  <meta name="keywords" content="web development, digital solutions, custom websites, web design, programming, software development">
  <meta name="author" content="NDFProject Team">
  <meta name="robots" content="index, follow">
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:title" content="{{ $title ?? 'NDFProject - Web Development & Digital Solutions' }}">
  <meta property="og:description" content="{{ $description ?? 'Web development services and digital solutions' }}">
  <meta property="og:image" content="{{ asset('img/ndflogo.png') }}">
  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="{{ url()->current() }}">
  <meta property="twitter:title" content="{{ $title ?? 'NDFProject - Web Development & Digital Solutions' }}">
  <meta property="twitter:description" content="{{ $description ?? 'Web development services and digital solutions' }}">
  <meta property="twitter:image" content="{{ asset('img/ndflogo.png') }}">
  <!-- Schema.org -->
  <meta itemprop="name" content="NDFProject">
  <meta itemprop="description" content="{{ $description ?? 'Web development services and digital solutions' }}">
  <meta itemprop="image" content="{{ asset('img/ndflogo.png') }}">
  <!-- Favicon and App Icons -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.ico') }}">
  <link rel="apple-touch-icon" href="{{ asset('img/favicon.ico') }}">
  <!-- Preload Resources -->
  <link rel="preload" href="{{ asset('css/bootstrap.css') }}" as="style">
  <link rel="preload" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" as="style">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Raleway:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700;800&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

 <!-- Hope You Find It Someday -->
 <!-- https://ndfproject.my.id/beloved -->
 
  <!-- Canonical URL -->
  <link rel="canonical" href="{{ url()->current() }}">
    <!-- Scripts -->
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
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.gtm.id') }}"></script>
  <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
          dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', '{{ config('services.gtm.id') }}');
  </script>
  <script src="{{ asset('vendor/lazysizes/lazysizes.min.js') }}" async></script>
</head>
<body>
  <div id="spinner" class="spinner-wrapper">
    <div class="text-center d-flex">
      <div class="spinner-grow spinner-grow-sm text-white" style="width: 1rem; height: 1rem;" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="text-white ms-2" style="font-family: 'Courier New', Courier, monospace">Optimizing ... Just a moment!</p>
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
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/typed.js/typed.umd.js') }}"></script>
  <script src="{{ asset('js/event/event.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
   <script>
    window.addEventListener('load', function() {
      document.getElementById('spinner').style.display = 'none';
    });
    document.getElementById("seeMoreBtn").addEventListener("click", function () {
    document.querySelectorAll(".portfolio-item.hidden").forEach(item => {
      item.classList.remove("hidden");
    });
    // Hide the button after showing all items
    this.style.display = "none";
  });
  </script>
  
  
</body>
</html>