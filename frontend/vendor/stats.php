<?php
$titulo = 'Listar Ventas';
$clase = "bg-info";
include_once '../vendor/inicio.html';
?>

    <!-- Begin Page Content -->
    <div class="container-fluid" id="contendorPrincipal">
        <h1 class="h3 mb-4 text-gray-800">Estadísticas</h1>
        <p>En esta sección podrás ver las estadísticas de ventas, productos más vendidos y más.</p>

        <canvas id="ventasMesChart"></canvas>
        <canvas id="productosMesChart"></canvas>
        <canvas id="productosDiaChart"></canvas>

    </div>
    <!-- End of Main Content -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            function fetchStats() {
                fetch('<?= $URL_BASE; ?>utiles/stats.php', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': '<?= $_SESSION['token']; ?>'
                    }
                })
            .then(response => response.json())
            .then(data => {
                // Ventas por mes
                const ventasMesCtx = document.getElementById('ventasMesChart').getContext('2d');
                new Chart(ventasMesCtx, {
                    type: 'bar',
                    data: {
                        labels: data.ventas_mes.map(item => item.mes),
                        datasets: [{
                            label: 'Ventas por mes',
                            data: data.ventas_mes.map(item => item.total_ventas),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    }
                });

                // Productos más vendidos del último mes
                const productosMesCtx = document.getElementById('productosMesChart').getContext('2d');
                new Chart(productosMesCtx, {
                    type: 'pie',
                    data: {
                        labels: data.productos_mes.map(item => item.producto),
                        datasets: [{
                            label: 'Productos más vendidos',
                            data: data.productos_mes.map(item => item.total_vendido),
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                        }]
                    }
                });

                // Producto más vendido según el día de la semana
                const productosDiaCtx = document.getElementById('productosDiaChart').getContext('2d');
                new Chart(productosDiaCtx, {
                    type: 'bar',
                    data: {
                        labels: data.productos_dia.map(item => item.dia_semana),
                        datasets: [{
                            label: 'Producto más vendido por día',
                            data: data.productos_dia.map(item => item.total_vendido),
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }]
                    }
                });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            fetchStats();
            });
    </script>

<?php
include_once '../vendor/fin.html';
?>