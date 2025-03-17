<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="/" class="text-nowrap logo-img">
          <img src="{{ asset('img/ndflogo.png') }}" alt="" width="200px"/>
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
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
              <button id="scanQRBtn" class="btn btn-primary .bg-gradient-primary rounded-circle scan-btn">
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
<div class="modal fade" id="scanQRModal" tabindex="-1" aria-labelledby="scanQRModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content rounded-4">
      <div class="modal-header border-0 pb-0">
        <div class="w-100 d-flex justify-content-between align-items-center">
          <h5 class="modal-title fs-6 text-muted">Scan QR Code</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>
      <div class="modal-body pt-0">
        <div class="scanner-container position-relative overflow-hidden rounded-3">
          <div id="reader" style="width: 100%; height: 300px;"></div>
          <div class="scanning-frame">
            <div class="corner top-left"></div>
            <div class="corner top-right"></div>
            <div class="corner bottom-left"></div>
            <div class="corner bottom-right"></div>
          </div>
          <button type="button" 
                  id="toggleFlashBtn" 
                  class="btn btn-primary btn-sm position-absolute shadow-sm"
                  style="display: none; bottom: 16px; right: 16px; width: 40px; height: 40px; border-radius: 20px">
            <i class="bi bi-lightbulb"></i>
          </button>
        </div>
        <div class="text-center mt-4">
          <p class="text-muted mb-2 small">Arahkan kamera ke QR Code</p>
          <div class="mb-3">
            <input type="range" class="form-range" id="zoomSlider" min="1" max="10" step="0.1" value="1">
          </div>
          <div class="scan-result bg-light rounded-2 p-2">
            <p class="mb-0 small">
              <span class="text-muted">Hasil:</span> 
              <span id="result" class="fw-bold text-primary text-wrap d-inline-block w-100">
              </span>
            </p>
            <div id="actionButtons" class="mt-2 d-none">
              <button id="copyBtn" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-clipboard-check me-1"></i>Copy</button>
              <button id="saveBtn" class="btn btn-sm btn-primary"><i class="bi bi-cloud-arrow-up me-1"></i>Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


