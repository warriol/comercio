$(document).ready(function() {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true
    });

    // Fetch clients, sellers, and products
    fetch(URL_BASE + 'comercio/backend/clientes/listar.php')
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

    fetch(URL_BASE + 'comercio/backend/vendedores/listar.php')
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

    fetch(URL_BASE + 'comercio/backend/productos/listar.php')
        .then(response => response.json())
        .then(data => {
            const productoSelect = document.getElementById('productoSelect');
            data.forEach(producto => {
                const option = document.createElement('option');
                option.value = producto.idProducto;
                option.text = producto.nombre + ' [' + producto[precioAtributo] + ' $ - ' + producto.tipo + ']';
                option.dataset.precio = producto[precioAtributo];
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

        fetch(URL_BASE + 'comercio/backend/ventas/create.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('responseMessage').innerHTML = `<div class="alert alert-success">${data.message}</div>`;

                // Ocultar el formulario original
                document.getElementById('ventaForm').style.display = 'none';

                // Crear y mostrar el nuevo formulario
                const nuevoFormulario = document.createElement('div');
                nuevoFormulario.innerHTML = `
                            <div class="container mt-5">
                                <div class="alert alert-primary" role="alert">Pago del Cliente</div>
                                <div id="resumenVenta">
                                    <p><strong>Cliente:</strong> ${document.getElementById('idClienteInput').value} || <strong>Vendedor:</strong> ${document.getElementById('idVendedor').options[document.getElementById('idVendedor').selectedIndex].text}</p>
                                    <p><strong>Fecha de Venta:</strong> ${document.getElementById('fechaVenta').value} || <strong>Fecha de Entrega:</strong> ${document.getElementById('fechaEntrega').value}</p>
                                    <p><strong>Tipo de Venta:</strong> ${document.getElementById('tipoVenta').value}</p>
                                    <p><strong>Total:</strong> $ ${document.getElementById('totalVenta').value}</p>
                                </div>
                                <form id="pagoForm">
                                    <div class="form-group">
                                        <label for="montoPagado">Monto Pagado</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" id="montoPagado" name="montoPagado" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="vuelto">Vuelto</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" class="form-control" id="vuelto" name="vuelto" readonly>
                                        </div>
                                    </div>
                                    <div class="btn-toolbar justify-content-between">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">Calcular Vuelto</button>
                                        </div>
                                        <div class="btn-group">
                                            <a href="../dashboard.php" class="btn btn-secondary">Volver al Inicio</a>
                                            <a href="crearClientes.php" class="btn btn-warning">Crear otra Venta</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        `;

                document.getElementById('contentForm').appendChild(nuevoFormulario);

                document.getElementById('pagoForm').addEventListener('submit', function(event) {
                    event.preventDefault();
                    const montoPagado = parseFloat(document.getElementById('montoPagado').value);
                    const totalVenta = parseFloat(document.getElementById('totalVenta').value);
                    const vuelto = montoPagado - totalVenta;
                    document.getElementById('vuelto').value = vuelto.toFixed(2);
                });
            })
            .catch(error => {
                document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Hubo un error al crear la venta.</div>`;
            });
    });
});