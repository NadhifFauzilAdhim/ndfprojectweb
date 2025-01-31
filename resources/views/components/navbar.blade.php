<nav id="navbar" class="nav-menu navbar">
    <ul>
        <li>
            <a href="/" class="{{ request()->is('/') ? 'nav-link scrollto active' : 'nav-link scrollto' }}">
                <i class="bx bx-home"></i> <span>Home</span>
            </a>
        </li>
        <li><a href="/#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>About</span></a></li>
        <li><a href="/#resume" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Resume</span></a></li>
        <li><a href="/#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>Certificate</span></a></li>
        <li><a href="/#project" class="nav-link scrollto"><i class="bx bx-server"></i> <span>Project</span></a></li>
        <li><a href="/#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i> <span>Contact</span></a></li>
        <li class="dropdown">
            <a href="#" class="nav-link scrollto dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                <i class="bx bx-edit"></i> <span>Discover</span></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="/blog" class="{{ request()->is('blog') ? 'dropdown-item active' : 'dropdown-item' }} text-dark bg-transparent""><i class="bx bx-edit"></i>My Blog</a></li>
                <li><a href="/event" class="{{ request()->is('event') ? 'dropdown-item active' : 'dropdown-item' }} text-dark bg-transparent"><i class="bx bx-calendar-event"></i> Event</a></li>
            </ul>
        </li>
        @auth
        <!-- Dropdown for Dashboard and Logout -->
        <li class="dropdown">
            <a href="#" class="nav-link scrollto dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                <i class="bi bi-send fs-5"></i> <span>Dashboard</span></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="/dashboard" class="dropdown-item text-dark bg-transparent"><i class="bi bi-send fs-5"></i> Dashboard</a></li>
                <li>
                    <form action="/logout" method="POST" class="dropdown-item text-dark bg-transparent ps-3 pb-3">
                        @csrf
                        <button class="btn p-0 text-start" type="submit"><i class="bi bi-box-arrow-right fs-5"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </li>
        @else
        <li>
          <a href="/login" class="nav-link scrollto">
             <i class="bx bx-log-in"></i>
              <span>Login</span>
          </a>
      </li>
        @endauth
    </ul>
  </nav>
  