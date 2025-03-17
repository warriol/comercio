<?php
$titulo = 'Crear  Vendedor';
include_once '../vendor/inicio.html';
?>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        document.getElementById('vendedorForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = {
                nombre: document.getElementById('nombre').value,
                telefono: document.getElementById('telefono').value
            };

            fetch('<?= $URL_BASE; ?>comercio/backend/vendedores/create.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': '<?= $_SESSION['token']; ?>'
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
<?php
include_once '../vendor/fin.html';
?>