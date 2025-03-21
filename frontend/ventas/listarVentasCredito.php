<?php
$titulo = 'Listar Ventas a Crédito';
include_once '../vendor/inicio.html';
?>
    <div class="container mt-5">
        <form id="listarVentasCreditoForm">
            <div class="row">
                <div class="form-group col-10">
                    <label for="idCliente">Cliente</label>
                    <input type="text" class="form-control" id="idClienteInput" name="idClienteInput"
                           placeholder="Buscar cliente" required>
                    <select class="form-control mt-2" id="idCliente" name="idCliente" size="5">
                        <!-- Opciones de clientes -->
                    </select>
                </div>
                <div class="col-2 d-flex">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>
        <table class="table mt-3" id="ventasCreditoTable">
            <thead>
            <tr>
                <th>ID Venta</th>
                <th>Fecha de Venta</th>
                <th>Fecha de Entrega</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <!-- Detalles de ventas a crédito -->
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>Total:</strong></td>
                <td id="totalCredito"></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {

            // Fetch clients and populate the select element
            fetch(URL_BASE + 'comercio/backend/clientes/listarClientesConVentasCredito.php', {
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

                    clienteInput.addEventListener('input', function () {
                        const searchTerm = clienteInput.value.toLowerCase();
                        clienteSelect.innerHTML = '';
                        clientes.forEach(option => {
                            if (option.text.toLowerCase().includes(searchTerm)) {
                                clienteSelect.appendChild(option);
                            }
                        });
                    });

                    clienteSelect.addEventListener('change', function () {
                        clienteInput.value = clienteSelect.options[clienteSelect.selectedIndex].text;
                    });
                });

            $('#listarVentasCreditoForm').on('submit', function(event) {
                event.preventDefault();
                const idCliente = $('#idCliente').val();

                fetch(URL_BASE + `comercio/backend/ventas/listarVentasCredito.php?idCliente=${idCliente}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': '<?= $_SESSION['token']; ?>'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        const tableBody = $('#ventasCreditoTable tbody');
                        let total = 0;
                        let lastIdVenta = null;
                        tableBody.empty();

                        data.forEach(venta => {
                            total += parseFloat(venta.subtotal);
                            const row = `<tr class="${venta.idVenta === lastIdVenta ? 'table-warning' : ''}">
                            <td>${venta.idVenta}</td>
                            <td>${venta.fechaVenta}</td>
                            <td>${venta.fechaEntrega}</td>
                            <td>${venta.nombre}</td>
                            <td>${venta.cantidad}</td>
                            <td>${venta.subtotal}</td>
                            <td>${venta.idVenta === lastIdVenta ? '' : '<button class="btn btn-success saldarDeudaBtn" data-id-venta="' + venta.idVenta + '">Saldar Deuda</button>'}</td>
                        </tr>`;
                            tableBody.append(row);
                            lastIdVenta = venta.idVenta;
                        });

                        $('#totalCredito').text(total.toFixed(2));

                        $('.saldarDeudaBtn').on('click', function() {
                            const idVenta = $(this).data('id-venta');
                            saldarDeuda(idVenta);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            function saldarDeuda(idVenta) {
                fetch(URL_BASE + `comercio/backend/ventas/saldarDeuda.php?idVenta=${idVenta}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': '<?= $_SESSION['token']; ?>'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        $('#listarVentasCreditoForm').submit();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    </script>
<?php
include_once '../vendor/fin.html';
?>