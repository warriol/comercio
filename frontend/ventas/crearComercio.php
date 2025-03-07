<?php
$titulo = 'Crear Ventas para Comercio';
include_once '../vendor/inicio.html';
?>
<script>
    precioAtributo = 'precioEsp';
</script>
<div class="container my-5">
    <div id="responseMessage" class="mt-3"></div>

    <div id="contentForm">
        <div class="alert alert-warning" role="alert">Crear Venta para Comercio</div>
        <form id="ventaForm">
            <div class="row">
                <div class="form-group col-6">
                    <label for="idCliente">Cliente</label>
                    <input type="text" class="form-control" id="idClienteInput" name="idClienteInput" placeholder="Buscar comercio" required>
                    <select class="form-control mt-2" id="idCliente" name="idCliente" size="5" style="display: none;">
                        <!-- Opciones de clientes -->
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="idVendedor">Vendedor</label>
                    <select class="form-control" id="idVendedor" name="idVendedor" required>
                        <!-- Opciones de vendedores -->
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="text-info col-12">
                    <small>Para una VENTA, la fecha de venta y entrega son la misma.</small>
                </div>
                <div class="form-group col-6">
                    <label for="fechaVenta">Fecha de Venta</label>
                    <input type="text" class="form-control" id="fechaVenta" name="fechaVenta" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>
                <div class="form-group col-6">
                    <label for="fechaEntrega">Fecha de Entrega</label>
                    <input type="text" class="form-control datepicker" id="fechaEntrega" name="fechaEntrega"
                           value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="tipoVenta">Tipo de Venta</label>
                <select class="form-control" id="tipoVenta" name="tipoVenta" required>
                    <option value="contado">Contado</option>
                    <option value="credito">Crédito</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comentarios">Comentarios</label>
                <textarea class="form-control" id="comentarios" name="comentarios"></textarea>
            </div>
            <hr>
            <div class="row justify-content-between">
                <div class="form-group col-4">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#productoModal">Agregar Producto</button>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-6 text-right">
                            <label for="totalVenta">Total</label>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control text-right" id="totalVenta" name="totalVenta" readonly aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table mt-3" id="detalleVentaTable">
                <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <!-- Detalles de productos -->
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Crear Pedido</button>
            <button type="submit" class="btn btn-primary">Crear Venta</button>
        </form>
    </div>
</div>

<!-- Modal para agregar productos -->
<div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="productoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productoModalLabel">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="productoSelect">Producto</label>
                    <select class="form-control" id="productoSelect" name="productoSelect" required>
                        <!-- Opciones de productos -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="cantidadProducto">Cantidad</label>
                    <input type="range" class="form-control" id="cantidadProducto" name="cantidadProducto" min="0.5" max="50" step="0.5" required>
                    <input type="number" class="form-control" id="cantidadProductoNumber" name="cantidadProductoNumber" min="0.5" max="50" step="0.5" required>
                </div>
                <div class="form-group">
                    <label for="subtotalProducto">Subtotal</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" id="subtotalProducto" name="subtotalProducto" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="agregarProductoBtn">Agregar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../vendor/js/utiles.js"></script>
<?php
include_once '../vendor/fin.html';
?>