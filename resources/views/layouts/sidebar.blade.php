<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Inventario <sup></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="index.html">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>

<!-- Nav Item - Pages Collapse Menu -->

<li class="nav-item">
    <a class="nav-link" href="/admin/">
        <i class="fas fa-gavel"></i>
        <span>Admin</span>
    </a>
</li>
@if(Auth::user()->nivel == 'admin')
<li class="nav-item">
    <a class="nav-link " href="/admin/usuarios/">
        <i class="fas fa-users"></i>
        <span>Usuarios</span>
    </a>
</li>
@endif

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
   Produción
</div>



<!-- Nav Item - Charts -->
<li class="nav-item">
    <a class="nav-link" href="/admin/productos">
        <i class="fas fa-fw fa-table"></i>
        <span>Inventario</span></a>
</li>
<!-- Nav Item - Tables -->

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



</ul>
