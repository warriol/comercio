<?php
$titulo = 'Crear Proveedor';
include_once '../vendor/inicio.html';
?>

    <div class="container mt-5">
        <form id="proveedorForm">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>

            <div class="form-group">
                <label for="servicio">Servicio</label>
                <input type="text" class="form-control" id="servicio" name="servicio" required>
            </div>
            <div class="form-group">
                <label for="costo">Costo</label>
                <input type="number" class="form-control" id="costo" name="costo" required>
            </div>
        </form>
    </div>

<?php
include_once '../vendor/fin.html';
?>