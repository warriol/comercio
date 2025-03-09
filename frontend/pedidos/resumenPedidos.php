<?php
$titulo = 'Resumen de Pedidos del dìa';
$clase = "bg-secondary";
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <form id="resumenPedidosForm">
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
    <table class="table mt-3" id="resumenPedidosTable">
        <thead>
        <tr>
            <th>Producto</th>
            <th>Tipo</th>
            <th>Total Cantidad</th>
        </tr>
        </thead>
        <tbody>
        <!-- Resumen de pedidos -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#resumenPedidosForm').on('submit', function(event) {
            event.preventDefault();
            const fechaPedido = $('#fechaPedido').val();

            fetch(`<?= $URL_BASE; ?>comercio/backend/pedidos/listar.php?fechaPedido=${fechaPedido}`)
                .then(response => response.json())
                .then(data => {
                    const resumen = {};

                    data.forEach(pedido => {
                        const key = `${pedido.producto}-${pedido.tipo}`;
                        if (!resumen[key]) {
                            resumen[key] = {
                                producto: pedido.producto,
                                tipo: pedido.tipo,
                                totalCantidad: 0
                            };
                        }
                        resumen[key].totalCantidad += parseFloat(pedido.cantidad);
                    });

                    const tableBody = $('#resumenPedidosTable tbody');
                    tableBody.empty();

                    Object.values(resumen).forEach(item => {
                        const row = `<tr>
                            <td>${item.producto}</td>
                            <td>${item.tipo}</td>
                            <td>${item.totalCantidad}</td>
                        </tr>`;
                        tableBody.append(row);
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
