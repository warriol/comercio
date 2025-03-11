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

    public function listar_ventas_credito_por_cliente(int $idCliente)
    {
        try {
            $stmt = $this->conn->prepare(
                'SELECT ve.idVenta, ve.fechaVenta, ve.fechaEntrega, ve.tipoVenta, dv.idProducto, dv.cantidad, dv.subtotal, dv.subtotal AS total
                FROM ventas ve
                JOIN detalleventas dv ON ve.idVenta = dv.idVenta
                WHERE ve.idCliente = :idCliente AND ve.tipoVenta = "credito"'
            );
            $stmt->bindParam(':idCliente', $idCliente);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

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