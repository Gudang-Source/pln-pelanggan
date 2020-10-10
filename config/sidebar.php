<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PLN <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Beranda -->
    <li class="nav-item <?=isset($home)?'active':'';?>">
        <a class="nav-link" href="?#">
            <i class="fas fa-fw fa-home"></i>
            <span>Beranda</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <?php if($_SESSION['level']=='admin'):?>
    <!-- Nav Item - Pelanggan -->
    <li class="nav-item <?=isset($pelanggan)?'active':'';?>">
        <a class="nav-link" href="?pelanggan">
            <i class="fas fa-fw fa-address-card"></i>
            <span>Pelanggan</span></a>
    </li>
    <?php endif; ?>

    <!-- Nav Item - Tagihan -->
    <li class="nav-item <?=isset($tagihan)?'active':'';?>">
        <a class="nav-link" href="?tagihan">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Tagihan</span></a>
    </li>

    <?php if($_SESSION['level']=='admin'):?>
    <!-- Nav Item - Pengguna -->
    <li class="nav-item <?=isset($pengguna)?'active':'';?>">
        <a class="nav-link" href="?pengguna">
            <i class="fas fa-fw fa-user"></i>
            <span>Pengguna</span></a>
    </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->