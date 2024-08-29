<nav id="navbar" class="nav-menu navbar">
    <ul>
      <li><a href="/" class="{{ request()->is('/') ? 'nav-link scrollto active' : 'nav-link scrollto' }}"><i class="bx bx-home"></i> <span>Home</span></a></li>
      <li><a href="/#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>About</span></a></li>
      <li><a href="/#resume" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Resume</span></a></li>
      <li><a href="/#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>Certificate</span></a></li>
      <li><a href="/#project" class="nav-link scrollto"><i class="bx bx-server"></i> <span>Project</span></a></li>
      <li><a href="/#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i> <span>Contact</span></a></li>
      <li><a href="/blog" class="{{ request()->is('blog') ? 'nav-link scrollto active' : 'nav-link scrollto' }}"><i class="bi bi-pencil-square"></i> <span>Blog</span></a></li>
      <li><a href="/cms" class="nav-link scrollto"><i class="bi bi-send"></i> <span>CMS</span></a></li>
      
    </ul>
  </nav><!-- .nav-menu -->