<?php
$titulo = 'Crear Ventas para Clientes';
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <div class="alert alert-primary" role="alert">
        Crear Venta Clientes
    </div>
    <form id="ventaForm">
        <div class="row">
            <div class="form-group col-6">
                <label for="idCliente">Cliente</label>
                <select class="form-control" id="idCliente" name="idCliente" required>
                    <!-- Opciones de clientes -->
                </select>
            </div>
            <div class="form-group col-6">
                <label for="idVendedor">Vendedor</label>
                <select class="form-control" id="idVendedor" name="idVendedor" required>
                    <!-- Opciones de vendedores -->
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                <label for="fechaVenta">Fecha de Venta</label>
                <input type="text" class="form-control" id="fechaVenta" name="fechaVenta" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>
            <div class="form-group col-6">
                <label for="fechaEntrega">Fecha de Entrega</label>
                <input type="text" class="form-control datepicker" id="fechaEntrega" name="fechaEntrega" required>
            </div>
        </div>
        <div class="form-group">
            <label for="tipoVenta">Tipo de Venta</label>
            <select class="form-control" id="tipoVenta" name="tipoVenta" required>
                <option value="contado">Contado</option>
                <option value="credito">Crédito</option>
            </select>
        </div>
        <div class="form-group">
            <label for="comentarios">Comentarios</label>
            <textarea class="form-control" id="comentarios" name="comentarios"></textarea>
        </div>
        <hr>
        <div class="row justify-content-between">
            <div class="form-group col-4">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#productoModal">Agregar Producto</button>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-6 text-right">
                        <label for="totalVenta">Total</label>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control text-right" id="totalVenta" name="totalVenta" readonly aria-label="Amount (to the nearest dollar)">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table mt-3" id="detalleVentaTable">
            <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <!-- Detalles de productos -->
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Crear Venta</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
</div>

<!-- Modal para agregar productos -->
<div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="productoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productoModalLabel">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="productoSelect">Producto</label>
                    <select class="form-control" id="productoSelect" name="productoSelect" required>
                        <!-- Opciones de productos -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="cantidadProducto">Cantidad</label>
                    <input type="range" class="form-control" id="cantidadProducto" name="cantidadProducto" min="1" max="50" step="1" required>
                    <input type="number" class="form-control" id="cantidadProductoNumber" name="cantidadProductoNumber" min="1" max="50" step="1" required>
                </div>
                <div class="form-group">
                    <label for="subtotalProducto">Subtotal</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" id="subtotalProducto" name="subtotalProducto" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregarProductoBtn">Agregar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });

        // Fetch clients, sellers, and products
        fetch('<?= $URL_BASE; ?>comercio/backend/clientes/listar.php')
            .then(response => response.json())
            .then(data => {
                const clienteSelect = document.getElementById('idCliente');
                data.forEach(cliente => {
                    const option = document.createElement('option');
                    option.value = cliente.idCliente;
                    option.text = cliente.nombre + ' ' + cliente.apellido + ' - ' + cliente.telefono;
                    clienteSelect.appendChild(option);
                });
            });

        fetch('<?= $URL_BASE; ?>comercio/backend/vendedores/listar.php')
            .then(response => response.json())
            .then(data => {
                const vendedorSelect = document.getElementById('idVendedor');
                data.forEach(vendedor => {
                    const option = document.createElement('option');
                    option.value = vendedor.idVendedor;
                    option.text = vendedor.nombre;
                    vendedorSelect.appendChild(option);
                });
            });

        fetch('<?= $URL_BASE; ?>comercio/backend/productos/listar.php')
            .then(response => response.json())
            .then(data => {
                const productoSelect = document.getElementById('productoSelect');
                data.forEach(producto => {
                    const option = document.createElement('option');
                    option.value = producto.idProducto;
                    option.text = producto.nombre + ' [' + producto.precio + ' $ - ' + producto.tipo + ']';
                    option.dataset.precio = producto.precio;
                    productoSelect.appendChild(option);
                });
            });

        document.getElementById('cantidadProducto').addEventListener('input', function() {
            const productoSelect = document.getElementById('productoSelect');
            const selectedOption = productoSelect.options[productoSelect.selectedIndex];
            const precio = selectedOption.dataset.precio;
            const cantidad = this.value;
            const subtotal = precio * cantidad;
            document.getElementById('subtotalProducto').value = subtotal.toFixed(2);
            document.getElementById('cantidadProductoNumber').value = cantidad;
        });

        document.getElementById('cantidadProductoNumber').addEventListener('input', function() {
            const productoSelect = document.getElementById('productoSelect');
            const selectedOption = productoSelect.options[productoSelect.selectedIndex];
            const precio = selectedOption.dataset.precio;
            const cantidad = this.value;
            const subtotal = precio * cantidad;
            document.getElementById('subtotalProducto').value = subtotal.toFixed(2);
            document.getElementById('cantidadProducto').value = cantidad;
        });

        document.getElementById('agregarProductoBtn').addEventListener('click', function() {
            const productoSelect = document.getElementById('productoSelect');
            const selectedOption = productoSelect.options[productoSelect.selectedIndex];
            const productoId = selectedOption.value;
            const productoNombre = selectedOption.text;
            const cantidad = document.getElementById('cantidadProducto').value;
            const subtotal = document.getElementById('subtotalProducto').value;

            const tableBody = document.getElementById('detalleVentaTable').getElementsByTagName('tbody')[0];
            const newRow = tableBody.insertRow();
            newRow.innerHTML = `<td>${productoNombre}</td><td>${cantidad}</td><td>$ ${subtotal}</td><td><button type="button" class="btn btn-danger btn-sm eliminarProductoBtn">Eliminar</button></td>`;
            newRow.dataset.productoId = productoId;
            newRow.dataset.cantidad = cantidad;
            newRow.dataset.subtotal = subtotal;

            actualizarTotalVenta();

            $('#productoModal').modal('hide');
            document.getElementById('productoSelect').value = '';
            document.getElementById('cantidadProducto').value = '';
            document.getElementById('subtotalProducto').value = '';

            // Add event listener to the new delete button
            newRow.querySelector('.eliminarProductoBtn').addEventListener('click', function() {
                newRow.remove();
                actualizarTotalVenta();
            });
        });


        function actualizarTotalVenta() {
            const tableBody = document.getElementById('detalleVentaTable').getElementsByTagName('tbody')[0];
            let total = 0;
            for (let i = 0; i < tableBody.rows.length; i++) {
                total += parseFloat(tableBody.rows[i].dataset.subtotal);
            }
            document.getElementById('totalVenta').value = total.toFixed(2);
        }

        document.getElementById('ventaForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('idCliente', document.getElementById('idCliente').value);
            formData.append('idVendedor', document.getElementById('idVendedor').value);
            formData.append('fechaVenta', document.getElementById('fechaVenta').value);
            formData.append('fechaEntrega', document.getElementById('fechaEntrega').value);
            formData.append('tipoVenta', document.getElementById('tipoVenta').value);
            formData.append('comentarios', document.getElementById('comentarios').value);

            const tableBody = document.getElementById('detalleVentaTable').getElementsByTagName('tbody')[0];
            const detalles = [];
            for (let i = 0; i < tableBody.rows.length; i++) {
                const row = tableBody.rows[i];
                detalles.push({
                    idProducto: row.dataset.productoId,
                    cantidad: row.dataset.cantidad,
                    subtotal: row.dataset.subtotal
                });
            }
            formData.append('detalles', JSON.stringify(detalles));

            fetch('<?= $URL_BASE; ?>comercio/backend/ventas/create.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('responseMessage').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                })
                .catch(error => {
                    document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Hubo un error al crear la venta.</div>`;
                });
        });
    });
</script>
<?php
include_once '../vendor/fin.html';
?>