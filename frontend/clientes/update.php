<?php
if (isset($_GET["idCliente"])) {
    $idCliente = $_GET["idCliente"];
} else {
    header("Location: /comercio/frontend/clientes/listar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Cliente</h2>
    <form id="editarClienteForm">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <button type="submit" class="btn btn-primary">Editar Cliente</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
</div>

<script>

    // Obtener el cliente por ID
    fetch(`https://localhost/comercio/backend/clientes/getById.php?idCliente=<?= $idCliente; ?>`)
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

        // Construir la URL con parámetros GET
        const url = new URL('https://localhost/comercio/backend/clientes/update.php');
        const params = {};
        params.idCliente = <?= $idCliente; ?>;
        if (nombre) params.nombre = nombre;
        if (apellido) params.apellido = apellido;
        if (telefono) params.telefono = telefono;
        if (correo) params.correo = correo;
        url.search = new URLSearchParams(params).toString();

        // Realizar la petición
        fetch(url, {
            method: 'PUT'
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('responseMessage').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        })
        .catch(error => {
            document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Hubo un error al actualizar el cliente</div>`;
        });
    });
</script>
</body>
</html>