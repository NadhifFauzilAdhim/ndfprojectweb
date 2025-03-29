<header id="header">
  <div class="d-flex flex-column">

    <div class="profile">
      @auth
        @if(Auth::user()->avatar)
        <img data-src="{{ asset('public/'. auth()->user()->avatar) }}" alt="" class="img-fluid rounded-circle author-img lazyload">
        @elseif (Auth::user()->google_avatar)
        <img data-src="{{ Auth::user()->google_avatar }}" alt="" class="img-fluid rounded-circle author-img lazyload">
        @else
        <img data-src="https://img.icons8.com/color/500/user-male-circle--v1.png" alt="" class="img-fluid rounded-circle author-img lazyload">
         @endif
      @else
      <img src="{{ asset('img/author.png') }}" alt="" class="img-fluid rounded-circle author-img">
      @endauth
      @auth
      <h1 class="sitename text-white">{{ auth()->user()->name}} @can ('verified') <i class="bi bi-patch-check-fill text-primary"></i> @endcan</h1>
      @else
      <h1 class="text-light"><a href="#"><img class="logo-img" src="{{ asset('img/project/ndfproject-logo-white.png') }}" alt=""></a></h1>
      @endauth
     
      <div class="social-links mt-3 text-center">
        <a href="mailto:nadya15a3@gmail.com" class="mail" target="_blank"><i class="bi bi-envelope-arrow-up" title="Email"></i></a>
        <a href="https://www.instagram.com/nadhif_f.a/" class="instagram" target="_blank"><i class="bx bxl-instagram" title="Instagram"></i></a>
        <a href="https://wa.link/89jklc" class="whatsapp" target="_blank"><i class="bx bxl-whatsapp" title="WhatsApp"></i></a>
        <a href="https://www.linkedin.com/in/nadhif-fauzil-adhim-99a330294" target="_blank" class="linkedin"><i class="bx bxl-linkedin" title="LinkedIn"></i></a>
    </div>
    
    </div>
    @auth
      @can('verified')
          <!-- Konten untuk pengguna yang sudah terverifikasi -->
      @else
      <div class="text-center">
          <a class="btn btn-warning btn-sm mt-1 rounded-pill" role="alert" href="/email/verify">
              <small class=""><i class="bi bi-exclamation-octagon-fill"></i> Email Not Verified</small>
          </a>
      </div>
      @endcan
  @endauth
    <x-navbar></x-navbar>

  </div>
</header><!-- End Header -->