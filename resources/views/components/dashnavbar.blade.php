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
          <li class="sidebar-item">
            <a class="sidebar-link "  href="/dashboard/posts" aria-expanded="false">
              <span>
                <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">My Post</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/dashboard/posts/create" aria-expanded="false">
              <span>
                <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
              </span>
              <span class="hide-menu">Create Post</span>
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
            <a class="sidebar-link" href="/dashboard/allpost" aria-expanded="false">
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