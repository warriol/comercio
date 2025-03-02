<?php
$titulo = 'Crear Cliente';
include_once '../vendor/inicio.html';
?>
    <div class="container mt-5">
        <form id="clienteForm">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo">
            </div>
            <button type="submit" class="btn btn-primary">Crear Cliente</button>
        </form>
        <div id="responseMessage" class="mt-3"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        document.getElementById('clienteForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = {
                nombre: document.getElementById('nombre').value,
                apellido: document.getElementById('apellido').value,
                telefono: document.getElementById('telefono').value,
                correo: document.getElementById('correo').value
            };

            // Show spinner
            document.getElementById('responseMessage').innerHTML = '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';

            fetch('<?= $URL_BASE; ?>comercio/backend/clientes/create.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('responseMessage').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    document.getElementById('clienteForm').reset(); // Reset form
                })
                .catch(error => {
                    document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Hubo un error al creando al cliente.</div>`;
                });
        });
    </script>

<?php
include_once '../vendor/fin.html';
?>