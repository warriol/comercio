<?php
if (isset($_GET["idProducto"])) {
    $idProducto = $_GET["idProducto"];
} else {
    $PREFIJO = ($_SERVER['HTTP_HOST'] == 'localhost') ? '/comercio/frontend' : '';
    header("Location: ".$PREFIJO."/productos/listar.php");
    exit;
}

$titulo = 'Acualizar Productos';
include_once '../vendor/inicio.html';
?>
<div class="container mt-5">
    <h2>Actualizar Producto</h2>
    <form id="productoForm">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
        </div>
        <div class="form-group">
            <label for="precioEsp">Precio Especial</label>
            <input type="number" step="0.01" class="form-control" id="precioEsp" name="precioEsp" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <select class="form-control" id="tipo" name="tipo" required>
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
        <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        fetch(`<?= $URL_BASE; ?>productos/getById.php?idProducto=<?= $idProducto; ?>`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': '<?= $_SESSION['token']; ?>'
            }
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('precio').value = data.precio;
                document.getElementById('precioEsp').value = data.precioEsp;
                document.getElementById('tipo').value = data.tipo;
                // Create an img element to display the image
                const imgElement = document.createElement('img');
                imgElement.src = `/imagenes/${data.imagen}`;
                imgElement.alt = data.nombre;
                imgElement.width = 100; // Set the desired width
                document.getElementById('imagen').parentNode.appendChild(imgElement);
            })
            .catch(error => {
                document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Error al cargar el producto.</div>`;
            });

        document.getElementById('productoForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const url = new URL('<?= $URL_BASE; ?>productos/update.php');
            const formData = new FormData();

            formData.append('_method', 'PUT');  // Simulamos el método PUT
            formData.append('idProducto', <?= $idProducto; ?>);
            formData.append('nombre', document.getElementById('nombre').value);
            formData.append('precio', document.getElementById('precio').value);
            formData.append('precioEsp', document.getElementById('precioEsp').value);
            formData.append('tipo', document.getElementById('tipo').value);

            if (document.getElementById('imagen').files[0]) {
                formData.append('imagen', document.getElementById('imagen').files[0]);
            }

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': '<?= $_SESSION['token']; ?>'
                }
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('responseMessage').innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    document.getElementById('productoForm').reset(); // Reset form
                })
                .catch(error => {
                    console.log(error);
                    document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">Hubo un error al actualizar el producto.</div>`;
                });
        });
    });
</script>
<?php
include_once '../vendor/fin.html';
?>