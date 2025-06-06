<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between p-3 py-3">
        <a href="/dashboard/profile" class="d-flex align-items-center text-decoration-none text-dark">
          <div class="position-relative">
            @if(Auth::user()->profile_picture)
              <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                   alt="Profile" 
                   class="rounded-circle shadow-sm"
                   width="48" 
                   height="48"
                   style="object-fit: cover; border: 2px solid #fff;">
            @elseif(Auth::user()->google_avatar)
              <img src="{{ Auth::user()->google_avatar }}" 
                   alt="Profile" 
                   class="rounded-circle shadow-sm"
                   width="48" 
                   height="48"
                   style="object-fit: cover; border: 2px solid #fff;">
            @else
              <div class="avatar-placeholder bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                   style="width: 48px; height: 48px; background-color: {{ '#'.substr(md5(Auth::user()->id), 0, 6) }};">
                <span class="text-white fs-5 fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
              </div>
            @endif
            <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"></span>
          </div>
          <div class="ms-3">
            <span class="d-block fw-semibold mb-0">{{ Auth::user()->name }}</span>
            <small class="text-muted">@if(auth()->user()->is_admin) Admin @else Basic @endif</small>
          </div>
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer">
          <i class="bi bi-x-lg fs-6"></i>
        </div>
      </div>
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
            <span class="hide-menu">Home</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/dashboard" aria-expanded="false">
              <span>
                <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
            <span class="hide-menu">User Menu</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link " href="/dashboard/profile" aria-expanded="false">
              <span>
                <iconify-icon icon="solar:user-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">Profile</span>
            </a>
          </li>
          @can('admin')
          <li class="sidebar-item">
            <a class="sidebar-link " href="/dashboard/posts" aria-expanded="false">
              <span>
               
                <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">My Post</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/dashboard/posts/create" aria-expanded="false">
              <span>
                <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">Create Post</span>
            </a>
          </li>
          @endcan
          
          <li class="sidebar-item">
            <a class="sidebar-link" href="/dashboard/link" aria-expanded="false">
              <span>
                <iconify-icon icon="solar:link-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">Links Hub
            </span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/dashboard/todolist" aria-expanded="false">
              <span>
                <iconify-icon icon="solar:archive-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">To-Do List
                <span class="badge bg-success d-inline-flex align-items-center justify-content-center ms-2"><small>New</small></span>
            </span>
            </a>
          </li>
          @can('admin')
          <li class="nav-small-cap">
            <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4" class="fs-6"></iconify-icon>
            <span class="hide-menu">Administrator</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/dashboard/categories" aria-expanded="false">
              <span>
                <iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">Categories</span>
            </a>
          </li>
          
          <li class="sidebar-item">
            <a class="sidebar-link" href="/dashboard/postmanagement" aria-expanded="false">
              <span>
                <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">All Post</span>
            </a>
          </li>
          @endcan
          @can('owner')
          <li class="nav-small-cap">
            <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4" class="fs-6"></iconify-icon>
            <span class="hide-menu">Owner</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/dashboard/usersetting" aria-expanded="false">
              <span>
                <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">User Verif</span>
            </a>
          </li>
          @endcan
        </ul>
        <div class="unlimited-access hide-menu bg-primary-subtle position-relative mb-7 mt-7 rounded-3"> 
          <div class="d-flex">
            <div class="unlimited-access-title me-3">
              <h6 class="fw-semibold fs-4 mb-6 text-dark w-75">Check Out Our New Feature!</h6>
              <a href="https://linksy.site/updatelog" target="_blank"
                class="btn btn-primary fs-2 fw-semibold lh-sm">Change Log</a>
            </div>
            <div class="unlimited-access-img">
              <img src="{{ asset('img/rocket.png') }}" alt="" class="img-fluid">
            </div>
          </div>
        </div>
      </nav>
    </div>
  </aside>

  <nav class="navbar fixed-bottom navbar-light d-block d-lg-none mobile-nav">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center w-100 px-2">
            <a class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                <div class="nav-icon">
                    <iconify-icon icon="solar:home-smile-bold-duotone"></iconify-icon>
                </div>
                <span class="nav-label">Home</span>
            </a>

            <a class="nav-item {{ request()->is('dashboard/link*') ? 'active' : '' }}" href="/dashboard/link">
                <div class="nav-icon">
                    <iconify-icon icon="solar:link-bold-duotone"></iconify-icon>
                </div>
                <span class="nav-label">Links</span>
            </a>

            <div class="nav-item scan-wrapper">
              <button id="scanQRBtn" class="btn btn-primary bg-gradient-primary rounded-circle scan-btn scan-btn-animated">
                <iconify-icon icon="solar:qr-code-bold-duotone" width="24" height="24"></iconify-icon>
              </button>
              <span class="nav-label">Scan</span>
            </div>
            @can('admin')
            <a class="nav-item {{ request()->is('dashboard/posts*') ? 'active' : '' }}" href="/dashboard/posts">
                <div class="nav-icon">
                    <iconify-icon icon="solar:text-field-focus-bold-duotone"></iconify-icon>
                </div>
                <span class="nav-label">Post</span>
            </a>
            @else
            <a class="nav-item {{ request()->is('dashboard/posts*') ? 'active' : '' }}">
              <div class="nav-icon">
                  <iconify-icon icon="solar:text-field-focus-bold-duotone"></iconify-icon>
              </div>
              <span class="nav-label">Post</span>
          </a>
            @endcan

            <a class="nav-item {{ request()->is('dashboard/profile') ? 'active' : '' }}" href="/dashboard/profile">
                <div class="nav-icon">
                    <iconify-icon icon="solar:user-bold-duotone"></iconify-icon>
                </div>
                <span class="nav-label">Profile</span>
            </a>
        </div>
    </div>
</nav>
<x-scannerpopup></x-scannerpopup>


