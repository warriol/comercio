<?php
if (isset($_GET['idVendedor'])) {
    $idVendedor = $_GET['idVendedor'];
} else {
    header('Location: /comercio/frontend/vendedores/listar.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Vendedor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {

        fetch(`https://localhost/comercio/backend/vendedores/getById.php?idVendedor=<?= $idVendedor; ?>`)
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
            event.preventDefault();// seguir aca


        });
    });
</script>
</body>
</html>