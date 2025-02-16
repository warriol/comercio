<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Vendedor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Crear Vendedor</h2>
        <form id="vendedorForm">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Vendedor</button>
        </form>
        <div id="responseMessage" class="mt-3"></div>
    </div>

    <script>
        document.getElementById('vendedorForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = {
                nombre: document.getElementById('nombre').value,
                telefono: document.getElementById('telefono').value
            };

            fetch('https://localhost/comercio/backend/vendedores/create.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('responseMessage').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            })
            .catch(error => {
                document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Hubo un error al creando al vendedor.</div>`;
            });
        });
    </script>
</body>
</html>