<?php
$titulo = 'Listar Productos';
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <h2>Buscar Producto</h2>
    <form id="buscarForm">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <select class="form-control" id="tipo" name="tipo">
                <option value="">Todos</option>
                <option value="por kilo">por kilo</option>
                <option value="por unidad">por unidad</option>
                <option value="por mitad">por mitad</option>
                <option value="oferta">oferta</option>
                <option value="paquete">paquete</option>
                <option value="100">100</option>
                <option value="grande">grande</option>
                <option value="chico">chico</option>
                <option value="mediano">mediano</option>
                <option value="28cm">28cm</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Buscar Producto</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
    <table class="table mt-3" id="resultTable" style="display: none;">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Precio Especial</th>
            <th>Tipo</th>
            <th>Imagen</th>
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
                ¿Está seguro de que desea eliminar este producto?
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
    function confirmDelete(idProducto) {
        $('#deleteModal').modal('show');
        $('#confirmDeleteBtn').data('id', idProducto);
    }

    $('#confirmDeleteBtn').on('click', function() {
        const idProducto = $(this).data('id');
        fetch(`<?= $URL_BASE; ?>comercio/backend/productos/delete.php?idProducto=${idProducto}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': '<?= $_SESSION['token']; ?>'
            }
        })
            .then(response => {
                if (response.ok) {
                    buscarProductos();
                } else {
                    alert('Error al eliminar el producto');
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
    });

    document.getElementById('buscarForm').addEventListener('submit', function(event) {
        event.preventDefault();
        buscarProductos();
    });

    function buscarProductos() {
        const nombre = document.getElementById('nombre').value.trim();
        const tipo = document.getElementById('tipo').value.trim();

        const url = new URL('<?= $URL_BASE; ?>comercio/backend/productos/listar.php');
        const params = {};
        if (nombre) params.nombre = nombre;
        if (tipo) params.tipo = tipo;

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
                    responseMessage.innerHTML = '<div class="alert alert-warning">No se encontraron productos.</div>';
                    resultTable.style.display = 'none';
                } else {
                    responseMessage.innerText = '';
                    resultTable.style.display = 'table';
                    resultTableBody.innerHTML = '';

                    data.forEach(producto => {
                        const row = document.createElement('tr');
                        if (producto.activo == 1) {
                            row.classList.add('table-success');
                            btnProducto = '<button class="btn btn-danger" onclick="confirmDelete(${producto.idProducto})">Eliminar</button>';
                        } else {
                            row.classList.add('table-danger');
                            btnProducto = '<button class="btn btn-secondary" onclick="confirmDelete(${producto.idProducto})">Restaurar</button>';
                        }
                        row.innerHTML = `
                            <td>${producto.idProducto}</td>
                            <td>${producto.nombre}</td>
                            <td>${producto.precio}</td>
                            <td>${producto.precioEsp}</td>
                            <td>${producto.tipo}</td>
                            <td><img src="<?= $URL_BASE; ?>comercio/backend/imagenes/${producto.imagen}" alt="${producto.nombre}" width="50"></td>
                            <td>
                                <a href="update.php?idProducto=${producto.idProducto}" class="btn btn-primary">Editar</a>
                                ${btnProducto}
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