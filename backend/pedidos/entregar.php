<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\Pedido;

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["idPedido"])) {
    $pedidos = new Pedido();
    $retorno = $pedidos->entregar_pedido($data["idPedido"]);

    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(["message" => $retorno]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}