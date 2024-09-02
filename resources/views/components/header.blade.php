<header id="header">
    <div class="d-flex flex-column">

      <div class="profile">
        @if(Auth::check())
          @if(Auth::user()->avatar)
          <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="" class="img-fluid rounded-circle author-img">
          @else
          <img src="https://img.icons8.com/color/500/user-male-circle--v1.png" alt="" class="img-fluid rounded-circle author-img">
           @endif
        @else
        <img src="{{ asset('img/author.png') }}" alt="" class="img-fluid rounded-circle author-img">
        @endif

        @auth
        <h1 class="sitename text-white">{{ auth()->user()->name}}</h1>
        @else
        <h1 class="text-light"><a href="#"><img class="logo-img" src="{{ asset('img/project/ndfproject-logo-white.png') }}" alt=""></a></h1>
        @endauth
       
        <div class="social-links mt-3 text-center">
          <a href="mailto:nadya15a3@gmail.com" class="mail" target="_blank"><i class="bi bi-envelope-arrow-up"></i></a>
          <a href="https://www.instagram.com/nadhif_f.a/" class="instagram" target="_blank"><i class="bx bxl-instagram"></i></a>
          <a href="https://wa.link/89jklc" class="whatsapp" target="_blank"><i class="bx bxl-whatsapp"></i></a>
          <a href="https://www.linkedin.com/in/nadhif-fauzil-adhim-99a330294" target="_blank" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>
      </div>
      <x-navbar></x-navbar>
  
    </div>
  </header><!-- End Header -->