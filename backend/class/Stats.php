<?php

namespace class;

class Stats extends \Config
{

    private $conn;

    public function __construct()
    {
        parent::__construct();
        $this->conn = parent::getConnection();
    }

    public function getVentasPorMes()
    {
        try {
            $query = "SELECT mes, SUM(CASE WHEN tipo = 'venta' THEN total ELSE 0 END) AS total_ventas, SUM(CASE WHEN tipo = 'pedido' THEN total ELSE 0 END) AS total_pedidos, SUM(total) AS total_ingresos FROM (
                        -- Ventas
                        SELECT 
                            DATE_FORMAT(v.fechaVenta, '%Y-%m') AS mes,
                            dv.subtotal AS total,
                            'venta' AS tipo
                        FROM 
                            ventas v
                        JOIN 
                            detalleventas dv ON v.idVenta = dv.idVenta
                    
                        UNION ALL
                    
                        -- Pedidos
                        SELECT 
                            DATE_FORMAT(p.fechaPedido, '%Y-%m') AS mes,
                            dp.subtotal AS total,
                            'pedido' AS tipo
                        FROM 
                            pedidos p
                        JOIN 
                            detallepedidos dp ON p.idPedido = dp.idPedido
                    ) AS combinados
                    GROUP BY mes
                    ORDER BY mes ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ['error' => 'Error al obtener las ventas por mes: ' . $e->getMessage()];
        }
    }

    public function getProductosMasVendidosUltimoMes()
    {
        try {
            $query = "SELECT fecha, producto, tipo, total_vendido FROM (
                        SELECT 
                            fecha,
                            producto,
                            tipo,
                            total_vendido,
                            RANK() OVER (PARTITION BY fecha ORDER BY total_vendido DESC) AS rnk
                        FROM (
                            -- Ventas
                            SELECT 
                                v.fechaVenta AS fecha,
                                p.nombre AS producto,
                                p.tipo,
                                SUM(dv.cantidad) AS total_vendido
                            FROM ventas v
                            JOIN detalleventas dv ON v.idVenta = dv.idVenta
                            JOIN productos p ON dv.idProducto = p.idProducto
                            WHERE v.fechaVenta >= CURDATE() - INTERVAL 7 DAY
                            GROUP BY fecha, p.idProducto
                    
                            UNION ALL
                    
                            -- Pedidos
                            SELECT 
                                p2.fechaPedido AS fecha,
                                pr.nombre AS producto,
                                pr.tipo,
                                SUM(dp.cantidad) AS total_vendido
                            FROM pedidos p2
                            JOIN detallepedidos dp ON p2.idPedido = dp.idPedido
                            JOIN productos pr ON dp.idProducto = pr.idProducto
                            WHERE p2.fechaPedido >= CURDATE() - INTERVAL 7 DAY
                            GROUP BY fecha, pr.idProducto
                        ) AS combinado
                    ) AS ranked
                    WHERE rnk <= 3
                    ORDER BY fecha DESC, total_vendido DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ['error' => 'Error al obtener los productos más vendidos del último mes: ' . $e->getMessage()];
        }
    }

    public function getProductosMasVendidosPorDia()
    {
        try {
            $query = "SELECT producto, tipo, SUM(total_vendido) AS total FROM (
                        -- Ventas
                        SELECT 
                            p.nombre AS producto,
                            p.tipo,
                            SUM(dv.cantidad) AS total_vendido
                        FROM ventas v
                        JOIN detalleventas dv ON v.idVenta = dv.idVenta
                        JOIN productos p ON dv.idProducto = p.idProducto
                        WHERE v.fechaVenta >= CURDATE() - INTERVAL 30 DAY
                        GROUP BY p.idProducto
                    
                        UNION ALL
                    
                        -- Pedidos
                        SELECT 
                            p.nombre AS producto,
                            p.tipo,
                            SUM(dp.cantidad) AS total_vendido
                        FROM pedidos pe
                        JOIN detallepedidos dp ON pe.idPedido = dp.idPedido
                        JOIN productos p ON dp.idProducto = p.idProducto
                        WHERE pe.fechaPedido >= CURDATE() - INTERVAL 30 DAY
                        GROUP BY p.idProducto
                    ) AS combinado
                    GROUP BY producto, tipo
                    ORDER BY total DESC
                    LIMIT 3";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ['error' => 'Error al obtener los productos más vendidos por día: ' . $e->getMessage()];
        }
    }
}