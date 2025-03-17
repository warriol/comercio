<?php
$titulo = 'Listar Ventas';
$clase = "bg-info";
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <form id="listarVentasForm">
        <div class="row">
            <div class="form-group col-10">
                <label for="fechaVenta">Fecha de Venta</label>
                <input type="text" class="form-control datepicker" id="fechaVenta" name="fechaVenta" required>
            </div>
            <div class="col-2 d-flex">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
    </form>
    <table class="table mt-3" id="ventasTable">
        <thead>
        <tr>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Tipo</th>
            <th>Subtotal</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <!-- Detalles de ventas -->
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5" class="text-right">Total Ventas:</td>
            <td id="totalVentas"></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Total Ventas Contado:</td>
            <td class="table-success" id="totalVentasContado"></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Total Ventas Crédito:</td>
            <td class="table-warning" id="totalVentasCredito"></td>
        </tr>
        </tfoot>
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

        $('#listarVentasForm').on('submit', function(event) {
            enviarForm(event);
        });

        function enviarForm(event) {
            event.preventDefault();
            const fechaVenta = $('#fechaVenta').val();

            fetch(`<?= $URL_BASE; ?>comercio/backend/ventas/listar.php?fechaVenta=${fechaVenta}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': '<?= $_SESSION['token']; ?>'
                }
            })
                .then(response => response.json())
                .then(data => {
                    const tableBody = $('#ventasTable tbody');
                    tableBody.empty();
                    let totalVentas = 0;
                    let totalVentasContado = 0;
                    let totalVentasCredito = 0;

                    data.forEach(venta => {
                        const rowClass = venta.tipo === 'contado' ? 'table-success' : 'table-warning';
                        const row = `<tr class="${rowClass}">
                            <td>${venta.cliente}</td>
                            <td>${venta.vendedor}</td>
                            <td>${venta.producto}</td>
                            <td>${venta.cantidad}</td>
                            <td>${venta.tipo}</td>
                            <td>${venta.subtotal}</td>
                            <td>${venta.total}</td>
                        </tr>`;
                        tableBody.append(row);
                        if (venta.tipo === 'contado') {
                            totalVentasContado += parseFloat(venta.total);
                        } else {
                            totalVentasCredito += parseFloat(venta.total);
                        }
                        totalVentas += parseFloat(venta.total);
                    });

                    $('#totalVentas').text(totalVentas.toFixed(2));
                    $('#totalVentasContado').text(totalVentasContado.toFixed(2));
                    $('#totalVentasCredito').text(totalVentasCredito.toFixed(2));
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Check if the form was submitted from the dashboard
        const urlParams = new URLSearchParams(window.location.search);
        const fechaVenta = urlParams.get('fechaVenta');
        if (fechaVenta) {
            $('#fechaVenta').val(fechaVenta);
            $('#listarVentasForm').submit();
        }
    });
</script>
<?php
include_once '../vendor/fin.html';
?>