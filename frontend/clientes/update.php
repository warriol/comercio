<?php
if (isset($_GET["idCliente"])) {
    $idCliente = $_GET["idCliente"];
} else {
    header("Location: /comercio/frontend/clientes/listar.php");
    exit;
}
?>
<?php
$titulo = 'Actualizar Cliente';
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <h2>Editar Cliente</h2>
    <form id="editarClienteForm">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" >
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo">
        </div>
        <button type="submit" class="btn btn-primary">Editar Cliente</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>

    // Obtener el cliente por ID
    fetch(`<?= $URL_BASE; ?>comercio/backend/clientes/getById.php?idCliente=<?= $idCliente; ?>`)
    .then(response => response.json())
    .then(data => {
        document.getElementById('nombre').value = data.nombre;
        document.getElementById('apellido').value = data.apellido;
        document.getElementById('telefono').value = data.telefono;
        document.getElementById('correo').value = data.correo;
    })
    .catch(error => {
        document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Hubo un error al obtener el cliente</div>`;
    });


    document.getElementById('editarClienteForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Obtener valores del formulario
        const nombre = document.getElementById('nombre').value.trim();
        const apellido = document.getElementById('apellido').value.trim();
        const telefono = document.getElementById('telefono').value.trim();
        const correo = document.getElementById('correo').value.trim();

        // Show spinner
        document.getElementById('responseMessage').innerHTML = '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';

        // Construir la URL con parámetros GET
        const url = new URL('<?= $URL_BASE; ?>comercio/backend/clientes/update.php');
        const params = {};
        params.idCliente = <?= $idCliente; ?>;
        if (nombre) params.nombre = nombre;
        if (apellido) params.apellido = apellido;
        if (telefono) params.telefono = telefono;
        if (correo) params.correo = correo;
        url.search = new URLSearchParams(params).toString();

        // Realizar la petición
        fetch(url, {
            method: 'PUT',
            'Authorization': '<?= $_SESSION['token']; ?>'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            console.log(response);
            return response.json();
        })
        .then(data => {
            document.getElementById('responseMessage').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            document.getElementById('clienteForm').reset(); // Reset form
        })
        .catch(error => {
            document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Hubo un error al actualizar el cliente</div>`;
        });
    });
</script>
<?php
include_once '../vendor/fin.html';
?>