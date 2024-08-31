<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="bi bi-list"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)">
            <i class="bi bi-bell"></i>
            <div class="notification bg-primary rounded-circle"></div>
          </a>
        </li>
      </ul>
      <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
          <a href="#" target="_blank"
            class="btn btn-primary me-2"><span>{{ auth()->user()->name }}</span> </a>
            <button
            class="btn btn-success me-2"
            data-bs-toggle="popover"
            data-bs-placement="bottom"
            data-bs-content="{{ auth()->user()->is_admin == 1 ? 'Akun Anda adalah Admin. Anda memiliki akses penuh.' : 'Akun Anda Adalah Basic, Beberapa fitur dibatasi' }}"
        >
            <span>@if(auth()->user()->is_admin == 1) Admin @else Basic @endif</span>
        </button>
          
          <li class="nav-item dropdown">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
              aria-expanded="false">
              <img src="{{ asset('img/author.png') }}" alt="" width="35" height="35" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
              <div class="message-body">
                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-user fs-6"></i>
                  <p class="mb-0 fs-3">My Profile</p>
                </a>
                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-mail fs-6"></i>
                  <p class="mb-0 fs-3">My Account</p>
                </a>
                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-list-check fs-6"></i>
                  <p class="mb-0 fs-3">My Task</p>
                </a>
                <form action="/logout" method="POST">@csrf <input type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block" value="Logout"></form>
                
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
          var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
              return new bootstrap.Popover(popoverTriggerEl)
          })
      });
      </script>
  </header>