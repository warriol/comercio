<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\Venta;

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$fechaVenta = $_GET['fechaVenta'] ?? null;

if ($fechaVenta) {
    $ventas = new Venta();
    $result = $ventas->listar_ventas_por_fecha($fechaVenta);

    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}