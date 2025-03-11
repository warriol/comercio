<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\Venta;

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$idCliente = $_GET['idCliente'] ?? null;

if ($idCliente) {
    $ventas = new Venta();
    $result = $ventas->listar_ventas_credito_por_cliente($idCliente);

    //header('Content-Type: application/json');
    http_response_code(200);
    echo $result;
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}