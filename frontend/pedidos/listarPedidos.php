<?php
$titulo = 'Listar Pedidos';
$clase = "bg-info";
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <form id="listarPedidosForm">
        <div class="row">
            <div class="form-group col-10">
                <label for="fechaPedido">Fecha de Pedido</label>
                <input type="text" class="form-control datepicker" id="fechaPedido" name="fechaPedido" required>
            </div>
            <div class="col-2 d-flex">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
    </form>
    <table class="table mt-3" id="pedidosTable">
        <thead>
        <tr>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Tipo</th>
            <th>Subtotal</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <!-- Detalles de pedidos -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        let fechasPedidos = [];

        // Fetch the dates with orders
        fetch(`<?= $URL_BASE; ?>comercio/backend/pedidos/listarFechasPedidos.php`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': '<?= $_SESSION['token']; ?>'
            }
        })
            .then(response => response.json())
            .then(data => {
                fechasPedidos = data.map(date => {
                    const parsedDate = new Date(date);
                    parsedDate.setMinutes(parsedDate.getMinutes() + parsedDate.getTimezoneOffset());
                    return parsedDate;
                });
                initializeDatepicker();
            })
            .catch(error => {
                console.error('Error:', error);
            });

        function initializeDatepicker() {
            console.log(fechasPedidos);
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                beforeShowDay: function(date) {
                    const highlight = fechasPedidos.some(d =>
                        d.getFullYear() === date.getFullYear() &&
                        d.getMonth() === date.getMonth() &&
                        d.getDate() === date.getDate()
                    );
                    return highlight ? { classes: 'highlight' } : {};
                }
            });
        }

        $('#listarPedidosForm').on('submit', function(event) {
            event.preventDefault();
            const fechaPedido = $('#fechaPedido').val();

            fetch(`<?= $URL_BASE; ?>comercio/backend/pedidos/listar.php?fechaPedido=${fechaPedido}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': '<?= $_SESSION['token']; ?>'
                }
            })
                .then(response => response.json())
                .then(data => {
                    const tableBody = $('#pedidosTable tbody');
                    tableBody.empty();

                    data.forEach(pedido => {
                        const rowClass = pedido.estado === 1 ? 'table-success' : 'table-warning';
                        const row = `<tr class="${rowClass}">
                            <td>${pedido.cliente}</td>
                            <td>${pedido.vendedor}</td>
                            <td>${pedido.producto}</td>
                            <td>${pedido.cantidad}</td>
                            <td>${pedido.tipo}</td>
                            <td>${pedido.subtotal}</td>
                            <td>${pedido.estado === 0 ? `Pendiente` : `Entregado`}</td>
                            <td>
                                ${pedido.estado === 0 ? `<button class="btn btn-success btn-sm entregarPedidoBtn" data-id="${pedido.idPedido}">Entregar</button>` : ''}
                            </td>
                        </tr>`;
                        tableBody.append(row);
                    });

                    $('.entregarPedidoBtn').on('click', function() {
                        const idPedido = $(this).data('id');
                        fetch(`<?= $URL_BASE; ?>comercio/backend/pedidos/entregar.php`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': '<?= $_SESSION['token']; ?>'
                            },
                            body: JSON.stringify({ idPedido })
                        })
                            .then(response => response.json())
                            .then(data => {
                                alert(data.message);
                                $('#listarPedidosForm').submit();
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>
<?php
include_once '../vendor/fin.html';
?>