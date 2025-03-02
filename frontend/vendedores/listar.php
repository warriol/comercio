<?php
$titulo = 'Listar  Vendedor';
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <h2>Buscar Vendedor</h2>
    <form id="buscarForm">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <button type="submit" class="btn btn-primary">Buscar Vendedor</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
    <table class="table mt-3" id="resultTable" style="display: none;">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Teléfono</th>
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
                ¿Está seguro de que desea eliminar este vendedor?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="deleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    document.getElementById('buscarForm').addEventListener('submit', function(event) {
        event.preventDefault();
        buscarVendedores();
    });

    function buscarVendedores() {

        // Obtener los datos del formulario
        let nombre = document.getElementById('nombre').value;
        let telefono = document.getElementById('telefono').value;

        // Construir la URL con parámetros GET
        let url = new URL('<?= $URL_BASE; ?>comercio/backend/vendedores/listar.php');
        const params = {};
        if (nombre) params.nombre = nombre;
        if (telefono) params.telefono = telefono;

        // Agregar los parámetros a la URL
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                const responseMessage = document.getElementById('responseMessage');
                const resultTable = document.getElementById('resultTable');
                const resultTableBody = resultTable.querySelector('tbody');

                if (data.length === 0) {
                    responseMessage.innerHTML = `<div class="alert alert-warning">No se encontraron vendedores.</div>`;
                    resultTable.style.display = 'none';
                } else {
                    responseMessage.innerHTML = '';
                    resultTable.style.display = 'table';
                    resultTableBody.innerHTML = '';

                    data.forEach(vendedor => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${vendedor.idVendedor}</td>
                            <td>${vendedor.nombre}</td>
                            <td>${vendedor.telefono}</td>
                            <td>
                                <a href="update.php?idVendedor=${vendedor.idVendedor}" class="btn btn-primary">Editar</a>
                            </td>
                        `;
                        resultTableBody.appendChild(row);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>
<?php
include_once '../vendor/fin.html';
?>