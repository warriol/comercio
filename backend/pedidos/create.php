<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\Pedido;

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$data = $_POST;

if (isset($data["idCliente"]) && isset($data["idVendedor"]) && isset($data["fechaPedido"]) && isset($data["fechaEntrega"]) && isset($data["estado"]) && isset($data["comentarios"]) && isset($data["detalles"])) {
    $pedidos = new Pedido();
    $retorno = $pedidos->create_pedido($data["idCliente"], $data["idVendedor"], $data["fechaPedido"], $data["fechaEntrega"], $data["estado"], $data["comentarios"], json_decode($data["detalles"], true));

    http_response_code(201); // Código 201 para creación exitosa
    header('Content-Type: application/json');
    echo json_encode(["message" => $retorno]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}