<?php
namespace class;

class Venta extends \Config
{
    private $conn;

    public function __construct()
    {
        parent::__construct();
        $this->conn = parent::getConnection();
    }

    /**
     * @api {post} /ventas/create.php Crear venta
     * @apiName create_venta
     * @apiGroup Ventas
     * @apiVersion 1.0.0
     * @apiDescription Crea una venta con sus detalles. Los datos se envían como multipart/form-data.
     * @apiBody {Number} idCliente ID del cliente.
     * @apiBody {Number} idVendedor ID del vendedor.
     * @apiBody {String} fechaVenta Fecha de la venta (YYYY-MM-DD).
     * @apiBody {String} fechaEntrega Fecha de entrega (YYYY-MM-DD).
     * @apiBody {String} tipoVenta Tipo de venta: contado o credito.
     * @apiBody {String} comentarios Comentarios de la venta.
     * @apiBody {String} detalles JSON con los detalles {idProducto, cantidad, subtotal}.
     * @apiSuccess {String} message Venta creada correctamente.
     * @apiError (400) {String} message Faltan campos obligatorios.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /ventas/create.php
     */
    public function create_venta(mixed $idCliente, mixed $idVendedor, string $fechaVenta, string $fechaEntrega, string $tipoVenta, string $comentarios, array $detalles)
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare('INSERT INTO ventas (idCliente, idVendedor, fechaVenta, fechaEntrega, tipoVenta, comentario) VALUES (:idCliente, :idVendedor, :fechaVenta, :fechaEntrega, :tipoVenta, :comentario)');
            $stmt->bindParam(':idCliente', $idCliente);
            $stmt->bindParam(':idVendedor', $idVendedor);
            $stmt->bindParam(':fechaVenta', $fechaVenta);
            $stmt->bindParam(':fechaEntrega', $fechaEntrega);
            $stmt->bindParam(':tipoVenta', $tipoVenta);
            $stmt->bindParam(':comentario', $comentarios);
            $stmt->execute();

            $idVenta = $this->conn->lastInsertId();

            $stmtDetalle = $this->conn->prepare('INSERT INTO detalleventas (idVenta, idProducto, cantidad, subtotal) VALUES (:idVenta, :idProducto, :cantidad, :subtotal)');
            foreach ($detalles as $detalle) {
                $stmtDetalle->bindParam(':idVenta', $idVenta);
                $stmtDetalle->bindParam(':idProducto', $detalle['idProducto']);
                $stmtDetalle->bindParam(':cantidad', $detalle['cantidad']);
                $stmtDetalle->bindParam(':subtotal', $detalle['subtotal']);
                $stmtDetalle->execute();
            }

            $this->conn->commit();

            return 'Venta creada correctamente';
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * @api {get} /ventas/listar.php?fechaVenta=2026-01-01 Listar ventas por fecha
     * @apiName listar_ventas
     * @apiGroup Ventas
     * @apiVersion 1.0.0
     * @apiDescription Lista las ventas realizadas en una fecha.
     * @apiParam (Query) {String} [fechaVenta] Fecha de venta (YYYY-MM-DD) (obligatorio).
     * @apiSuccess {Object[]} ventas Ventas encontradas.
     * @apiError (400) {String} message La fecha es obligatoria.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /ventas/listar.php
     */
    public function listar_ventas_por_fecha(string $fechaVenta)
    {
        try {
            $stmt = $this->conn->prepare(
                'SELECT c.nombre AS cliente, v.nombre AS vendedor, p.nombre AS producto, p.tipo, dv.cantidad, dv.subtotal, dv.subtotal AS total, ve.tipoVenta as tipo
                FROM ventas ve
                JOIN clientes c ON ve.idCliente = c.idCliente
                JOIN vendedores v ON ve.idVendedor = v.idVendedor
                JOIN detalleventas dv ON ve.idVenta = dv.idVenta
                JOIN productos p ON dv.idProducto = p.idProducto
                WHERE ve.fechaVenta = :fechaVenta'
            );
            $stmt->bindParam(':fechaVenta', $fechaVenta);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * @api {get} /ventas/listarVentasCredito.php?idCliente=1 Listar ventas a crédito
     * @apiName listar_ventas_credito
     * @apiGroup Ventas
     * @apiVersion 1.0.0
     * @apiDescription Lista las ventas a crédito de un cliente.
     * @apiParam (Query) {Number} [idCliente] ID del cliente (obligatorio).
     * @apiSuccess {Object[]} ventas Ventas a crédito.
     * @apiError (400) {String} message El cliente es obligatorio.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /ventas/listarVentasCredito.php
     */
    public function listar_ventas_credito_por_cliente(int $idCliente)
    {
        try {
            $stmt = $this->conn->prepare(
                'SELECT ve.idVenta, ve.fechaVenta, ve.fechaEntrega, ve.tipoVenta, CONCAT(p.nombre, " [", p.precio, " $]") AS nombre, dv.cantidad, dv.subtotal
                    FROM ventas ve
                    JOIN detalleventas dv ON ve.idVenta = dv.idVenta
                    JOIN productos p ON dv.idProducto = p.idProducto
                    WHERE ve.idCliente = :idCliente AND ve.tipoVenta = "credito"'
            );
            $stmt->bindParam(':idCliente', $idCliente);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    /**
     * @api {post} /ventas/saldarDeuda.php?idVenta=1 Saldar deuda
     * @apiName saldar_deuda
     * @apiGroup Ventas
     * @apiVersion 1.0.0
     * @apiDescription Cambia una venta a crédito a contado.
     * @apiParam (Query) {Number} [idVenta] ID de la venta (obligatorio).
     * @apiSuccess {String} message Deuda saldada correctamente.
     * @apiError (400) {String} message La venta es obligatoria.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /ventas/saldarDeuda.php
     */
    public function saldar_deuda(int $idVenta)
    {
        try {
            $stmt = $this->conn->prepare('UPDATE ventas SET tipoVenta = "contado" WHERE idVenta = :idVenta');
            $stmt->bindParam(':idVenta', $idVenta);
            $stmt->execute();

            return 'Deuda saldada correctamente';
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
