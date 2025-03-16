<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\Pedido;

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$pedido = new Pedido();
$result = $pedido->listar_fechas_pedidos();

header('Content-Type: application/json');
echo json_encode($result);