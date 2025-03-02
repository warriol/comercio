<?php
$titulo = 'Listar Pedidos';
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <h2>Listar Pedidos del Día</h2>
    <form id="listarPedidosForm">
        <div class="form-group">
            <label for="fechaPedido">Fecha de Pedido</label>
            <input type="text" class="form-control datepicker" id="fechaPedido" name="fechaPedido" required>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
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
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('#listarPedidosForm').on('submit', function(event) {
            event.preventDefault();
            const fechaPedido = $('#fechaPedido').val();

            fetch(`<?= $URL_BASE; ?>comercio/backend/pedidos/listar.php?fechaPedido=${fechaPedido}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = $('#pedidosTable tbody');
                    tableBody.empty();

                    data.forEach(pedido => {
                        const rowClass = pedido.estado === 'entregado' ? 'table-success' : 'table-warning';
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
                                'Content-Type': 'application/json'
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