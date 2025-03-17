<?php
$titulo = 'Crear Pedido para Clientes';
$clase = "bg-warning";
include_once '../vendor/inicio.html';
?>
<div class="container my-5">
    <div id="responseMessage" class="mt-3"></div>

    <div id="contentForm">
        <form id="pedidoForm">
        <div class="row">
            <div class="form-group col-6">
                <label for="idCliente">Cliente</label>
                <input type="text" class="form-control" id="idClienteInput" name="idClienteInput" placeholder="Buscar cliente" required>
                <select class="form-control mt-2" id="idCliente" name="idCliente" size="5" style="display: none;">
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
            <div class="text-warning col-12">
                <small>Para un PEDIDO, la fecha de entrega debe ser mayor o igual a la de venta.</small>
            </div>
            <div class="form-group col-6">
                <label for="fechaPedido">Fecha de Pedido</label>
                <input type="text" class="form-control" id="fechaPedido" name="fechaPedido" value="<?php echo date('Y-m-d'); ?>" readonly>
            </div>
            <div class="form-group col-6">
                <label for="fechaEntrega">Fecha de Entrega</label>
                <input type="text" class="form-control datepicker" id="fechaEntrega" name="fechaEntrega" required>
            </div>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" id="estado" name="estado" required>
                <option value="no_entregado">No Entregado</option>
                <option value="entregado">Entregado</option>
            </select>
        </div>
        <div class="form-group">
            <label for="comentarios">Comentarios</label>
            <textarea class="form-control" id="comentarios" name="comentarios"></textarea>
        </div>
        <hr>
        <div class="row justify-content-between">
            <div class="form-group col-4 d-flex">
                <button type="button" class="btn btn-secondary w-100" data-toggle="modal" data-target="#productoModal">
                    Agregar Producto
                </button>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-6 d-flex align-items-center text-right">
                        <label for="totalPedido" class="w-100">Total</label>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control" id="totalPedido" name="totalPedido" readonly aria-label="Amount (to the nearest dollar)">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table mt-3" id="detallePedidoTable">
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
        <div id="responseMessageErr" class="mt-3"></div>
        <button type="submit" class="btn btn-primary">Crear Pedido</button>
    </form>
    </div>
</div>

<!-- Modal para agregar productos -->
<div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="productoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                    <input type="range" class="form-control" id="cantidadProducto" name="cantidadProducto" min="0.5" max="50" step="0.5" required>
                    <input type="number" class="form-control" id="cantidadProductoNumber" name="cantidadProductoNumber" min="0.5" max="50" step="0.5" required>
                </div>
                <div class="form-group">
                    <label for="subtotalProducto">Subtotal</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="text" class="form-control" id="subtotalProducto" name="subtotalProducto" readonly>
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
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        const urlCli = new URL('<?= $URL_BASE; ?>clientes/listar.php');
        const urlVen = new URL('<?= $URL_BASE; ?>vendedores/listar.php');
        const urlPro = new URL('<?= $URL_BASE; ?>productos/listar.php');
        const urlPed = new URL('<?= $URL_BASE; ?>pedidos/create.php');

        // Fetch clients, sellers, and products
        fetch(urlCli, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': '<?= $_SESSION['token']; ?>'
            }
        })
            .then(response => response.json())
            .then(data => {
                const clienteSelect = document.getElementById('idCliente');
                const clienteInput = document.getElementById('idClienteInput');
                let clientes = [];

                data.forEach(cliente => {
                    const option = document.createElement('option');
                    option.value = cliente.idCliente;
                    option.text = cliente.nombre + ' ' + cliente.apellido + ' - ' + cliente.telefono;
                    clienteSelect.appendChild(option);
                    clientes.push(option);
                });

                clienteInput.addEventListener('input', function() {
                    const searchTerm = clienteInput.value.toLowerCase();
                    clienteSelect.style.display = 'block';
                    clienteSelect.innerHTML = '';
                    clientes.forEach(option => {
                        if (option.text.toLowerCase().includes(searchTerm)) {
                            clienteSelect.appendChild(option);
                        }
                    });
                    if (clienteSelect.options.length === 0) {
                        clienteSelect.style.display = 'none';
                    }
                });

                clienteSelect.addEventListener('change', function() {
                    clienteInput.value = clienteSelect.options[clienteSelect.selectedIndex].text;
                    clienteSelect.style.display = 'none';
                });
            });

        fetch(urlVen, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': '<?= $_SESSION['token']; ?>'
            }
        })
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

        fetch(urlPro, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': '<?= $_SESSION['token']; ?>'
            }
        })
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

            const tableBody = document.getElementById('detallePedidoTable').getElementsByTagName('tbody')[0];
            const newRow = tableBody.insertRow();
            newRow.innerHTML = `<td>${productoNombre}</td><td>${cantidad}</td><td>$ ${subtotal}</td><td><button type="button" class="btn btn-danger btn-sm eliminarProductoBtn">Eliminar</button></td>`;
            newRow.dataset.productoId = productoId;
            newRow.dataset.cantidad = cantidad;
            newRow.dataset.subtotal = subtotal;

            actualizarTotalPedido();

            $('#productoModal').modal('hide');
            document.getElementById('productoSelect').value = '';
            document.getElementById('cantidadProducto').value = '';
            document.getElementById('subtotalProducto').value = '';

            // Add event listener to the new delete button
            newRow.querySelector('.eliminarProductoBtn').addEventListener('click', function() {
                newRow.remove();
                actualizarTotalPedido();
            });
        });

        function actualizarTotalPedido() {
            const tableBody = document.getElementById('detallePedidoTable').getElementsByTagName('tbody')[0];
            let total = 0;
            for (let i = 0; i < tableBody.rows.length; i++) {
                total += parseFloat(tableBody.rows[i].dataset.subtotal);
            }
            document.getElementById('totalPedido').value = total.toFixed(2);
        }

        document.getElementById('pedidoForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('idCliente', document.getElementById('idCliente').value);
            formData.append('idVendedor', document.getElementById('idVendedor').value);
            formData.append('fechaPedido', document.getElementById('fechaPedido').value);
            formData.append('fechaEntrega', document.getElementById('fechaEntrega').value);
            formData.append('estado', document.getElementById('estado').value);
            formData.append('comentarios', document.getElementById('comentarios').value);

            const tableBody = document.getElementById('detallePedidoTable').getElementsByTagName('tbody')[0]
            if (tableBody.rows.length === 0) {
                document.getElementById('responseMessageErr').innerHTML = `<div class="alert alert-warning">Debe agregar al menos un producto al pedido.</div>`;
                setTimeout(() => {
                    document.getElementById('responseMessageErr').innerHTML = '';
                }, 10000);
                return;
            }
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

            fetch(urlPed, {
                method: 'POST',
                body: formData,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': '<?= $_SESSION['token']; ?>'
                }
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('responseMessage').innerHTML = `<div class="alert alert-success">${data.message}</div>`;

                    // Ocultar el formulario original
                    document.getElementById('pedidoForm').style.display = 'none';

                    // Crear y mostrar el nuevo formulario
                    const nuevoFormulario = document.createElement('div');
                    nuevoFormulario.innerHTML = `
                            <div class="container mt-5">
                                <div id="resumenVenta">
                                    <p><strong>Cliente:</strong> ${document.getElementById('idClienteInput').value} || <strong>Vendedor:</strong> ${document.getElementById('idVendedor').options[document.getElementById('idVendedor').selectedIndex].text}</p>
                                    <p><strong>Fecha de Pedido:</strong> ${document.getElementById('fechaPedido').value} || <strong>Fecha de Entrega:</strong> ${document.getElementById('fechaEntrega').value}</p>
                                    <p><strong>Estado:</strong> ${document.getElementById('estado').value}</p>
                                    <p><strong>Total:</strong> $ ${document.getElementById('totalPedido').value}</p>
                                </div>
                                <div class="btn-toolbar justify-content-between">
                                    <div class="btn-group">
                                        <a href="../dashboard.php" class="btn btn-secondary">Volver al Inicio</a>
                                        <a href="crearClientes.php" class="btn btn-warning">Crear otro Pedido</a>
                                    </div>
                                </div>
                        `;
                    document.getElementById('contentForm').appendChild(nuevoFormulario);
                })
                .catch(error => {
                    document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Hubo un error al crear el pedido.<br>`+ error +`</div>`;
                });
        });
    });
</script>
<?php
include_once '../vendor/fin.html';
?>