<?php
// dashboard.php
include 'session.php';
?>
<!DOCTYPE html>
<html lang="esn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="panaderi el aleman">
    <meta name="author" content="wilson arriola">

    <title>Inicio</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="vendor/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Panadería <sup>Alemán</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Enlaces</div>

            <!-- Ventas -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSix"
                   aria-expanded="true" aria-controls="collapseSix">
                    <i class="fas fa-fw fa-calculator"></i>
                    <span>Ventas</span>
                </a>
                <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="ventas/crearClientes.php">Para Clientes</a>
                        <a class="collapse-item" href="ventas/crearComercio.php">Para Comercio</a>
                        <a class="collapse-item" href="ventas/listarVentas.php">Listar</a>
                        <a class="collapse-item" href="ventas/listarVentasCredito.php">Saldar Crédito</a>
                    </div>
                </div>
            </li>

            <!-- Pedidos -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
                   aria-expanded="true" aria-controls="collapseFour">
                    <i class="fas fa-fw fa-clipboard-check"></i>
                    <span>Pedidos</span>
                </a>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="pedidos/crearClientes.php">Para Clientes</a>
                        <a class="collapse-item" href="pedidos/crearComercio.php">Para Comercio</a>
                        <a class="collapse-item" href="pedidos/listarPedidos.php">Listar</a>
                        <a class="collapse-item" href="pedidos/resumenPedidos.php">Resumen</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Clientes -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                   aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-id-badge"></i>
                    <span>Clientes</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="clientes/crear.php">Crear</a>
                        <a class="collapse-item" href="clientes/listar.php">Listar</a>
                        <a class="collapse-item" href="clientes/update.php">Actualizar</a>
                    </div>
                </div>
            </li>

            <!-- Vendedores -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTree"
                   aria-expanded="true" aria-controls="collapseTree">
                    <i class="fas fa-fw fa-people-carry"></i>
                    <span>Vendedores</span>
                </a>
                <div id="collapseTree" class="collapse" aria-labelledby="headingTree" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="vendedores/crear.php">Crear</a>
                        <a class="collapse-item" href="vendedores/listar.php">Listar</a>
                        <a class="collapse-item" href="vendedores/update.php">Actualizar</a>
                    </div>
                </div>
            </li>

            <!-- Productos -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive"
                   aria-expanded="true" aria-controls="collapseFive">
                    <i class="fas fa-fw fa-box-open"></i>
                    <span>Productos</span>
                </a>
                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="productos/crear.php">Crear</a>
                        <a class="collapse-item" href="productos/listar.php">Listar</a>
                        <a class="collapse-item" href="productos/update.php">Actualizar</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Date and Time -->
                        <li class="nav-item">
                            <span class="nav-link">
                                <span id="currentDateTime" class="mr-2 d-none d-lg-inline text-gray-600"></span>
                            </span>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Nombre</span>
                                <img class="img-profile rounded-circle"
                                     src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" id="contendorPrincipal">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Accesos rápidos a: <em>VENTAS</em></h1>

                    <div class="card-deck mb-4">
                        <div class="card text-center bg-secondary text-white" style="width: 18rem;">
                            <div class="card-body d-flex flex-column align-items-center">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="img/clientes.png" alt="Icon" width="150" height="150" class="mr-3">
                                    <div>
                                        <h5 class="card-title">Crear Venta Para CLientes</h5>
                                        <p class="card-text">Crea un venta con precios generales para clientes.</p>
                                    </div>
                                </div>
                                <a href="ventas/crearClientes.php" class="btn btn-primary btn-lg btn-block">Ventas Clientes</a>
                            </div>
                        </div>

                        <div class="card text-center bg-secondary text-white" style="width: 18rem;">
                            <div class="card-body d-flex flex-column align-items-center">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="img/comercio.png" alt="Icon" width="150" height="150" class="mr-3">
                                    <div>
                                        <h5 class="card-title">Crear Venta Para Comercio</h5>
                                        <p class="card-text">Crea un ventas con precios especiales para comercio.</p>
                                    </div>
                                </div>
                                <a href="ventas/crearComercio.php" class="btn btn-primary btn-lg btn-block">Ventas Comercio</a>
                            </div>
                        </div>

                        <div class="card text-center border-info" style="width: 18rem;">
                            <div class="card-body d-flex flex-column align-items-center">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="img/lista.png" alt="Icon" width="150" height="150" class="mr-3">
                                    <div>
                                        <h5 class="card-title">Listar Ventas</h5>
                                        <p class="card-text">Ver lista de ventas.</p>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-outline-info btn-lg btn-block" id="listarVentasHoyBtn">Listar Ventas</a>
                            </div>
                        </div>
                    </div>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Accesos rápidos a: <em>PEDIDOS</em></h1>

                    <div class="card-deck mb-4">
                        <div class="card text-center bg-primary text-white" style="width: 18rem;">
                            <div class="card-body d-flex flex-column align-items-center">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="img/clientes.png" alt="Icon" width="150" height="150" class="mr-3">
                                    <div>
                                        <h5 class="card-title">Crear Pedido Para CLientes</h5>
                                        <p class="card-text">Crea un pedido con precios generales para clientes.</p>
                                    </div>
                                </div>
                                <a href="pedidos/crearClientes.php" class="btn btn-warning btn-lg btn-block">Pedidos Clientes</a>
                            </div>
                        </div>

                        <div class="card text-center bg-primary text-white" style="width: 18rem;">
                            <div class="card-body d-flex flex-column align-items-center">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="img/comercio.png" alt="Icon" width="150" height="150" class="mr-3">
                                    <div>
                                        <h5 class="card-title">Crear Pedido Para Comercio</h5>
                                        <p class="card-text">Crea un pedido con precios especiales para comercio.</p>
                                    </div>
                                </div>
                                <a href="pedidos/crearComercio.php" class="btn btn-warning btn-lg btn-block">Pedidos Comercio</a>
                            </div>
                        </div>

                        <div class="card text-center border-info" style="width: 18rem;">
                            <div class="card-body d-flex flex-column align-items-center">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="img/lista.png" alt="Icon" width="150" height="150" class="mr-3">
                                    <div>
                                        <h5 class="card-title">Listar Pedidos</h5>
                                        <p class="card-text">Ver lista de pedidos.</p>
                                    </div>
                                </div>
                                <a href="pedidos/listarPedidos.php" class="btn btn-outline-info btn-lg btn-block">Listar Pedidos</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-deck">
                        <div class="card text-center" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>

                        <div class="card text-center" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Wilson Arriola 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Si hace clic en el boton salir, cerraras tu sesion.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="logout.php">Salir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="vendor/js/sb-admin-2.min.js"></script>

    <script>
        document.getElementById('listarVentasHoyBtn').addEventListener('click', function() {
            const today = new Date().toISOString().split('T')[0];
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'ventas/listarVentas.php';
            form.id = 'listarVentasForm';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'fechaVenta';
            input.value = today;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        });

        function updateDateTime() {
            const now = new Date();
            const formattedDateTime = now.toLocaleString('es-ES', {
                dateStyle: 'full',
                timeStyle: 'medium'
            });
            document.getElementById('currentDateTime').textContent = formattedDateTime;
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

</body>

</html>