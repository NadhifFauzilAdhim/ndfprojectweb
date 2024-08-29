<nav id="navbar" class="nav-menu navbar">
  
    <ul>
      <li><a href="/" class="{{ request()->is('/') ? 'nav-link scrollto active' : 'nav-link scrollto' }}"><i class="bx bx-home"></i> <span>Home</span></a></li>
      <li><a href="/#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>About</span></a></li>
      <li><a href="/#resume" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Resume</span></a></li>
      <li><a href="/#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>Certificate</span></a></li>
      <li><a href="/#project" class="nav-link scrollto"><i class="bx bx-server"></i> <span>Project</span></a></li>
      <li><a href="/#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i> <span>Contact</span></a></li>
      <li><a href="/blog" class="{{ request()->is('blog') ? 'nav-link scrollto active' : 'nav-link scrollto' }}"><i class="bi bi-pencil-square"></i> <span>Blog</span></a></li>
      @auth
      <div class="dropdown ms-3">
        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle ms-1 me-1"></i> {{ auth()->user()->name }}
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
          <li><a class="dropdown-item active" href="/dashboard"><i class="bi bi-send text-white"></i>Dashboard</a></li>
          <li class="py-1">
            <form action="/logout" method="POST" >
              @csrf
              <button class="dropdown-item ms-3" type="submit"><i class="bi bi-box-arrow-right text-white me-1"></i>Logout</button>
            </form>
          </li>
          
        </ul>
      </div>
      @else
      <li><a href="/login" class="nav-link scrollto"><i class="bi bi-box-arrow-in-left"></i> <span>Login</span></a></li>
      @endauth
     
      
    </ul>
  </nav><!-- .nav-menu -->