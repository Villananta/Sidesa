<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon rotate-n-15">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
                </div>
                <div class="sidebar-brand-text mx-3">Sidesa</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : ''}}">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

       
            <!-- Nav Item - Tables -->
            @if (Auth::check() && Auth::user()->role->name === 'Admin')
            <!-- Nav Item - Tables (hanya untuk Admin) -->
             <li class="nav-item {{ request()->is('resident*') ? 'active' : ''}}">
            <a class="nav-link" href="/resident">
                <i class="fas fa-fw fa-table"></i>
                <span>Penduduk</span></a>
            <a class="nav-link" href="/account-list">
                <i class="fas fa-fw fa-user"></i>
                <span>Daftar Akun</span></a>
            <a class="nav-link" href="/account-request">
                <i class="fas fa-fw fa-user"></i>
                <span>Permintaan Akun</span></a>
            <a class="nav-link" href="/complaint">
                <i class="fas fa-fw fa-bullhorn"></i>
                <span>Pengaduan</span></a>
            </li>
            @elseif (Auth::check() && Auth::user()->role->name === 'User')
            <li class="nav-item {{ request()->is('complaint*') ? 'active' : ''}}">
                <a class="nav-link" href="/complaint">
                    <i class="fas fa-fw fa-bullhorn"></i>
                    <span>Pengaduan</span></a>
            </li>
             @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>