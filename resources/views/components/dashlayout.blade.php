<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title> {{ $title }} | NDFProject</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('css/dash.css') }}" />
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="https://unpkg.com/html5-qrcode"></script>
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
  <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "{{ config('services.clarity.id') }}");
  </script>
  <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
    window.OneSignalDeferred = window.OneSignalDeferred || [];
    OneSignalDeferred.push(async function(OneSignal) {
        await OneSignal.init({
        appId: "{{ config('services.onesignal.app_id') }}",
        safari_web_id: "web.onesignal.auto.477dedc8-8bcf-40fd-b64c-238033111672",
        notifyButton: {
            enable: true,
        },
        });
    });
    </script>
    <script src="{{ asset('vendor/lazysizes/lazysizes.min.js') }}" async></script>
</head>
<body>
  <div id="spinner" class="spinner-wrapper">
    <div class="text-center">
      <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
   <x-dashnavbar></x-dashnavbar>
    <div class="body-wrapper">
     <x-dashheader></x-dashheader>
      {{ $slot }}
    </div>
  </div>
  <script src="{{ asset('js/dashjs/scanner.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('vendor/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('js/dashjs/sidebarmenu.js') }}"></script>
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('js/dashjs/app.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/copy.js') }}"></script>
</body>
</html>