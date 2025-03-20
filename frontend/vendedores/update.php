<?php
if (isset($_GET['idVendedor'])) {
    $idVendedor = $_GET['idVendedor'];
} else {
    $PREFIJO = ($_SERVER['HTTP_HOST'] == 'localhost') ? '/comercio/frontend' : '';
    header("Location: ".$PREFIJO."/vendedores/listar.php");
    exit;
}

$titulo = 'Actualizar  Vendedor';
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <h2>Actualizar Vendedor</h2>
    <form id="vendedorForm">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Vendedor</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
        fetch(`<?= $URL_BASE; ?>vendedores/getById.php?idVendedor=<?= $idVendedor; ?>`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': '<?= $_SESSION['token']; ?>'
            }
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('telefono').value = data.telefono;
            })
            .catch(error => {
                document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Error al cargar el producto.</div>`;
            });

        document.getElementById('vendedorForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Obtener valores del formulario
            const nombre = document.getElementById('nombre').value.trim();
            const telefono = document.getElementById('telefono').value.trim();

            // Construir la URL con parametros GET
            const url = new URL('<?= $URL_BASE; ?>vendedores/update.php');
            const params = {};
            params.idVendedor = <?= $idVendedor; ?>;
            params.nombre = nombre;
            params.telefono = telefono;
            url.search = new URLSearchParams(params).toString();

            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': '<?= $_SESSION['token']; ?>'
                }
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('responseMessage').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    document.getElementById('vendedorForm').reset();
                })
                .catch(error => {
                    document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Hubo un error al actualizar el vendedor.</div>`;
                });

        });

</script>
<?php
include_once '../vendor/fin.html';
?>