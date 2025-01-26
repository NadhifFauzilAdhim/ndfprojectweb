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

  <nav class="navbar fixed-bottom navbar-light bg-light d-block d-lg-none">
    <div class="container-fluid justify-content-around">
        <a class="nav-link text-center {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
            <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-5"></iconify-icon>
            <span class="d-block">Home</span>
        </a>
        <a class="nav-link text-center {{ request()->is('dashboard/link*') ? 'active' : '' }}" href="/dashboard/link">
            <iconify-icon icon="solar:link-bold-duotone" class="fs-5"></iconify-icon>
            <span class="d-block">Linksy</span>
        </a>
        @can('admin')
        <a class="nav-link text-center {{ request()->is('dashboard/posts*') ? 'active' : '' }}" href="/dashboard/posts">
            <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-5"></iconify-icon>
            <span class="d-block">Post</span>
        </a>
        @endcan
        <a class="nav-link text-center {{ request()->is('dashboard/profile') ? 'active' : '' }}" href="/dashboard/profile">
            <iconify-icon icon="solar:user-bold-duotone" class="fs-5"></iconify-icon>
            <span class="d-block">Profile</span>
        </a>
    </div>
</nav>