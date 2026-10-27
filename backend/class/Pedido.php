<?php
namespace class;

class Pedido extends \Config
{
    private $conn;

    public function __construct()
    {
        parent::__construct();
        $this->conn = parent::getConnection();
    }

    /**
     * @api {post} /pedidos/create.php Crear pedido
     * @apiName create_pedido
     * @apiGroup Pedidos
     * @apiVersion 1.0.0
     * @apiDescription Crea un pedido con sus detalles. Los datos se envían como multipart/form-data.
     * @apiBody {Number} idCliente ID del cliente.
     * @apiBody {Number} idVendedor ID del vendedor.
     * @apiBody {String} fechaPedido Fecha del pedido (YYYY-MM-DD).
     * @apiBody {String} fechaEntrega Fecha de entrega (YYYY-MM-DD).
     * @apiBody {Number} estado Estado inicial del pedido.
     * @apiBody {String} comentarios Comentarios del pedido.
     * @apiBody {String} detalles JSON con los detalles {idProducto, cantidad, subtotal}.
     * @apiSuccess {String} message Pedido creado correctamente.
     * @apiError (400) {String} message Faltan campos obligatorios.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /pedidos/create.php
     */
    public function create_pedido(mixed $idCliente, mixed $idVendedor, string $fechaPedido, string $fechaEntrega, string $estado, string $comentarios, array $detalles)
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare('INSERT INTO pedidos (idCliente, idVendedor, fechaPedido, fechaEntrega, estado, comentarios) VALUES (:idCliente, :idVendedor, :fechaPedido, :fechaEntrega, :estado, :comentarios)');
            $stmt->bindParam(':idCliente', $idCliente);
            $stmt->bindParam(':idVendedor', $idVendedor);
            $stmt->bindParam(':fechaPedido', $fechaPedido);
            $stmt->bindParam(':fechaEntrega', $fechaEntrega);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':comentarios', $comentarios);
            $stmt->execute();

            $idPedido = $this->conn->lastInsertId();

            $stmtDetalle = $this->conn->prepare('INSERT INTO detallepedidos (idPedido, idProducto, cantidad, subtotal) VALUES (:idPedido, :idProducto, :cantidad, :subtotal)');
            foreach ($detalles as $detalle) {
                $stmtDetalle->bindParam(':idPedido', $idPedido);
                $stmtDetalle->bindParam(':idProducto', $detalle['idProducto']);
                $stmtDetalle->bindParam(':cantidad', $detalle['cantidad']);
                $stmtDetalle->bindParam(':subtotal', $detalle['subtotal']);
                $stmtDetalle->execute();
            }

            $this->conn->commit();

            return 'Pedido creado correctamente';
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * @api {get} /pedidos/listar.php?fechaPedido=2026-01-01 Listar pedidos por fecha
     * @apiName listar_pedidos
     * @apiGroup Pedidos
     * @apiVersion 1.0.0
     * @apiDescription Lista los pedidos cuya fecha de entrega coincide.
     * @apiParam (Query) {String} [fechaPedido] Fecha de entrega (YYYY-MM-DD) (obligatorio).
     * @apiSuccess {Object[]} pedidos Pedidos encontrados.
     * @apiError (400) {String} message La fecha es obligatoria.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /pedidos/listar.php
     */
    public function listar_pedidos_por_fecha(string $fechaPedido)
    {
        try {
            $stmt = $this->conn->prepare('
                SELECT p.idPedido, c.nombre AS cliente, v.nombre AS vendedor, pr.nombre AS producto, pr.tipo, dp.cantidad, dp.subtotal, p.estado
                FROM pedidos p
                JOIN clientes c ON p.idCliente = c.idCliente
                JOIN vendedores v ON p.idVendedor = v.idVendedor
                JOIN detallepedidos dp ON p.idPedido = dp.idPedido
                JOIN productos pr ON dp.idProducto = pr.idProducto
                WHERE p.fechaEntrega = :fechaPedido
            ');
            $stmt->bindParam(':fechaPedido', $fechaPedido);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * @api {get} /pedidos/listarFechasPedidos.php Listar fechas de pedidos
     * @apiName listar_fechas_pedidos
     * @apiGroup Pedidos
     * @apiVersion 1.0.0
     * @apiDescription Lista las fechas de entrega disponibles para pedidos.
     * @apiSuccess {String[]} fechas Fechas de entrega.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /pedidos/listarFechasPedidos.php
     */
    public function listar_fechas_pedidos()
    {
        try {
            $stmt = $this->conn->prepare('SELECT DISTINCT fechaEntrega FROM pedidos');
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * @api {post} /pedidos/entregar.php Entregar pedido
     * @apiName entregar_pedido
     * @apiGroup Pedidos
     * @apiVersion 1.0.0
     * @apiDescription Marca un pedido como entregado y crea la venta correspondiente.
     * @apiBody {Number} idPedido ID del pedido.
     * @apiSuccess {String} message Pedido entregado y venta creada correctamente.
     * @apiError (400) {String} message ID de pedido obligatorio.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /pedidos/entregar.php
     */
    public function entregar_pedido(int $idPedido)
    {
        try {
            $this->conn->beginTransaction();

            // Update the order status
            $stmt = $this->conn->prepare('UPDATE pedidos SET estado = 1 WHERE idPedido = :idPedido');
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();

            // Get order details
            $stmt = $this->conn->prepare('
                SELECT idCliente, idVendedor, fechaPedido, fechaEntrega, comentarios
                FROM pedidos
                WHERE idPedido = :idPedido
            ');
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
            $pedido = $stmt->fetch(\PDO::FETCH_ASSOC);

            /**
             * Los pedidos cuando son entregados se deben registrar como una venta
             * esta venta será registrada el día de la ENTREGA
             */
            // Insert into ventas
            $stmt = $this->conn->prepare('
                INSERT INTO ventas (idCliente, idVendedor, fechaVenta, fechaEntrega, tipoVenta, comentario)
                VALUES (:idCliente, :idVendedor, :fechaVenta, :fechaEntrega, "contado", :comentario)
            ');
            $stmt->bindParam(':idCliente', $pedido['idCliente']);
            $stmt->bindParam(':idVendedor', $pedido['idVendedor']);
            $stmt->bindParam(':fechaVenta', $pedido['fechaEntrega']);
            $stmt->bindParam(':fechaEntrega', $pedido['fechaEntrega']);
            $stmt->bindParam(':comentario', $pedido['comentarios']);
            $stmt->execute();

            $idVenta = $this->conn->lastInsertId();

            // Get order details
            $stmt = $this->conn->prepare('
                SELECT idProducto, cantidad, subtotal
                FROM detallepedidos
                WHERE idPedido = :idPedido
            ');
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
            $detalles = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Insert into detalleventa
            $stmt = $this->conn->prepare('
                INSERT INTO detalleventas (idVenta, idProducto, cantidad, subtotal)
                VALUES (:idVenta, :idProducto, :cantidad, :subtotal)
            ');
            foreach ($detalles as $detalle) {
                $stmt->bindParam(':idVenta', $idVenta);
                $stmt->bindParam(':idProducto', $detalle['idProducto']);
                $stmt->bindParam(':cantidad', $detalle['cantidad']);
                $stmt->bindParam(':subtotal', $detalle['subtotal']);
                $stmt->execute();
            }

            $this->conn->commit();

            return 'Pedido entregado y venta creada correctamente';
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            return 'Error: ' . $e->getMessage();
        }
    }

}
