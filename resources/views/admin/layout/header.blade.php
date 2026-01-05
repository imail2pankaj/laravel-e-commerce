<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
      <i class="icon-base ti tabler-menu-2 icon-md"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">

    <ul class="navbar-nav flex-row align-items-center ms-md-auto">

      <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
        <a
          class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
          href="javascript:void(0);"
          data-bs-toggle="dropdown"
          data-bs-auto-close="outside"
          aria-expanded="false">
          <span class="position-relative">
            <i class="icon-base ti tabler-bell icon-22px text-heading"></i>
            <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
          </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end p-0">
          <li class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
              <h6 class="mb-0 me-auto">Notification</h6>
              <div class="d-flex align-items-center h6 mb-0">
                <span class="badge bg-label-primary me-2"> New</span>
                <a
                  href="javascript:void(0)"
                  class="dropdown-notifications-all p-2 btn btn-icon"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Mark all as read"
                  ><i class="icon-base ti tabler-mail-opened text-heading"></i
                ></a>
              </div>
            </div>
          </li>
          <li class="dropdown-notifications-list scrollable-container">
           <p class="m-4"> Your Notifications...</p> 
          </li>
        </ul>
      </li>

      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a
          class="nav-link dropdown-toggle hide-arrow p-0"
          href="javascript:void(0);"
          data-bs-toggle="dropdown"
        >
          <div class="avatar avatar-online">
            <img src="{{ asset('assets/admin/img/avatars/1.png') }}" alt class="rounded-circle" />
          </div>
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="">
              <i class="icon-base ti tabler-user me-3 icon-md"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>
          <li><div class="dropdown-divider my-1"></div></li>
          <li>
            <form action="{{ route('admin.logout') }}" method="POST" class="d-flex align-items-center px-3">
              @csrf
              <button type="submit" class="dropdown-item p-0 d-flex align-items-center bg-transparent border-0">
                <i class="icon-base ti tabler-logout me-3 icon-md"></i>
                <span class="align-middle">Logout</span>
              </button>
            </form>
          </li>

        </ul>
      </li>

    </ul>
  </div>
</nav>