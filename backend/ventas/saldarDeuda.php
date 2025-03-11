<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\Venta;

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$idVenta = $_GET['idVenta'] ?? null;

if ($idVenta) {
    $ventas = new Venta();
    $result = $ventas->saldar_deuda($idVenta);

    header('Content-Type: application/json');
    echo json_encode(["message" => $result]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}
