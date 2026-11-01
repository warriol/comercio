<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $PREFIJO ?>/dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
        <div class="sidebar-brand-text mx-3">Panadería <sup>Alemán</sup></div>
    </a>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Enlaces</div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
            <i class="fas fa-fw fa-calculator"></i><span>Ventas</span>
        </a>
        <div id="collapseSix" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $PREFIJO ?>/ventas/crearClientes.php">Para Clientes</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/ventas/crearComercio.php">Para Comercio</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/ventas/listarVentas.php">Listar</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/ventas/listarVentasCredito.php">Saldar Crédito</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-fw fa-clipboard-check"></i><span>Pedidos</span>
        </a>
        <div id="collapseFour" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $PREFIJO ?>/pedidos/crearClientes.php">Para Clientes</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/pedidos/crearComercio.php">Para Comercio</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/pedidos/listarPedidos.php">Listar</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/pedidos/resumenPedidos.php">Resumen</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
            <i class="fas fa-fw fa-truck"></i><span>Proveedores</span>
        </a>
        <div id="collapseSeven" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $PREFIJO ?>/proveedores/crear.php">Crear</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/proveedores/listar.php">Listar</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/proveedores/update.php">Actualizar</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-id-badge"></i><span>Clientes</span>
        </a>
        <div id="collapseTwo" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $PREFIJO ?>/clientes/crear.php">Crear</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/clientes/listar.php">Listar</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/clientes/update.php">Actualizar</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTree" aria-expanded="true" aria-controls="collapseTree">
            <i class="fas fa-fw fa-people-carry"></i><span>Vendedores</span>
        </a>
        <div id="collapseTree" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $PREFIJO ?>/vendedores/crear.php">Crear</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/vendedores/listar.php">Listar</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/vendedores/update.php">Actualizar</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
            <i class="fas fa-fw fa-box-open"></i><span>Productos</span>
        </a>
        <div id="collapseFive" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $PREFIJO ?>/productos/crear.php">Crear</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/productos/listar.php">Listar</a>
                <a class="collapse-item" href="<?= $PREFIJO ?>/productos/update.php">Actualizar</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-fw fa-box-open"></i><span>Útiles</span>
        </a>
        <div id="collapseOne" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= $PREFIJO ?>/utiles/stats.php">Estadísticas</a>
            </div>
        </div>
    </li>

    <?php if (!empty($_SESSION['isAdmin'])): ?>
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <a class="nav-link" href="<?= $PREFIJO ?>/usuarios/index.php">
            <i class="fas fa-fw fa-users-cog"></i><span>Administración de usuarios</span>
        </a>
    </li>
    <?php endif; ?>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
