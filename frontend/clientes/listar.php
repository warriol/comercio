<?php
$titulo = 'Listar Cliente';
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <h2>Buscar Cliente</h2>
    <form id="buscarForm">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo">
        </div>
        <button type="submit" class="btn btn-primary">Buscar Cliente</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
    <table class="table mt-3" id="resultTable" style="display: none;">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea eliminar este cliente?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn" data-dismiss="modal">Eliminar</button>
            </div>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function confirmDelete(idCliente) {
        $('#deleteModal').modal('show');
        $('#confirmDeleteBtn').data('id', idCliente);
    }

    $('#confirmDeleteBtn').on('click', function() {
        const idCliente = $(this).data('id');
        fetch(`<?= $URL_BASE; ?>comercio/backend/clientes/delete.php?idCliente=${idCliente}`, {
            method: 'DELETE',
            'Authorization': '<?= $_SESSION['token']; ?>'
        })
            .then(response => {
                if (response.ok) {
                    buscarClientes();
                } else {
                    alert('Error al eliminar el cliente');
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
    });

    document.getElementById('buscarForm').addEventListener('submit', function(event) {
        event.preventDefault();
        buscarClientes();
    });
    function buscarClientes() {

        // Obtener valores del formulario
        const nombre = document.getElementById('nombre').value.trim();
        const apellido = document.getElementById('apellido').value.trim();
        const telefono = document.getElementById('telefono').value.trim();
        const correo = document.getElementById('correo').value.trim();

        // Construir la URL con parámetros GET
        const url = new URL('<?= $URL_BASE; ?>comercio/backend/clientes/listar.php');

        const params = {};
        if (nombre) params.nombre = nombre;
        if (apellido) params.apellido = apellido;
        if (telefono) params.telefono = telefono;
        if (correo) params.correo = correo;

        // Agregar parámetros a la URL
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': '<?= $_SESSION['token']; ?>'
            }
        })
            .then(response => response.json())
            .then(data => {
                const responseMessage = document.getElementById('responseMessage');
                const resultTable = document.getElementById('resultTable');
                const resultTableBody = resultTable.querySelector('tbody');

                if (data.length === 0) {
                    responseMessage.innerHTML = '<div class="alert alert-warning">No se encontraron clientes.</div>';
                    resultTable.style.display = 'none';
                } else {
                    responseMessage.innerText = '';
                    resultTable.style.display = 'table';
                    resultTableBody.innerHTML = '';

                    data.forEach(cliente => {
                        const row = document.createElement('tr');
                        if (cliente.activo == 1) {
                            row.classList.add('table-success');
                            btnCliente = `<button class="btn btn-danger" onclick="confirmDelete(${cliente.idCliente})">Eliminar</button>`;
                        } else {
                            row.classList.add('table-danger');
                            btnCliente = `<button class="btn btn-secondary">Restaurar</button>`;
                        }
                        row.innerHTML = `
                            <td>${cliente.idCliente}</td>
                            <td>${cliente.nombre}</td>
                            <td>${cliente.apellido}</td>
                            <td>${cliente.telefono}</td>
                            <td>${cliente.correo}</td>
                            <td>
                                <a href="update.php?idCliente=${cliente.idCliente}" class="btn btn-primary">Editar</a>
                                ${btnCliente}
                            </td>
                        `;
                        resultTableBody.appendChild(row);
                    });
                }
            })
            .catch(error => {
                document.getElementById('responseMessage').innerText = 'Error: ' + error;
            });
    }

</script>
<?php
include_once '../vendor/fin.html';
?>