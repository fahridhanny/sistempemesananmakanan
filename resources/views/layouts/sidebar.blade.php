<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-text mx-3">Warunk Bakso</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            @if(Auth()->user()->hak_akses == "pelayan")
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="/makanan">
                    <i class="fas fa-utensils"></i>
                    <span>Makanan</span></a>
            </li>
             <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="/minuman">
                    <i class="fas fa-wine-glass-alt"></i>
                    <span>Minuman</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="/keranjang/pesanan">
                    <i class="fas fa-shopping-basket"></i>
                    <span>Keranjang Pesanan</span></a>
            </li>
            @endif

            @if(auth()->user()->hak_akses != "admin")
            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="/pesanan/masuk">
                    <i class="fas fa-clipboard-list pr-2"></i>
                    <span>Pesanan Belum Dibayar</span></a>
            </li>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="/pesanan/keluar">
                    <i class="fas fa-clipboard-list pr-2"></i>
                    <span>Pesanan Sudah Dibayar</span></a>
            </li>
            @endif

            @if(auth()->user()->hak_akses == "admin")
                <hr class="sidebar-divider my-0">

                <li class="nav-item active">
                    <a class="nav-link" href="/menu">
                        <i class="fas fa-utensils pr-2"></i>
                        <span>Menu</span></a>
                </li>

                <hr class="sidebar-divider my-0">

                <li class="nav-item active">
                    <a class="nav-link" href="/user">
                        <i class="fas fa-users pr-2"></i>
                        <span>User</span></a>
                </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>