<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Stats;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

// Crear instancia de la clase Stats
$stats = new Stats();
// Obtener estadísticas
$ventas_mes = $stats->getVentasPorMes();
$productos_mes = $stats->getProductosMasVendidosUltimoMes();
$productos_dia = $stats->getProductosMasVendidosPorDia();

// Enviar datos al frontend
//header('Content-Type: application/json');
http_response_code(200);
echo json_encode([
    'ventas_mes' => $ventas_mes,
    'productos_mes' => $productos_mes,
    'productos_dia' => $productos_dia
]);
