<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Venta;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$data = $_POST;

if (isset($data["idCliente"]) && isset($data["idVendedor"]) && isset($data["fechaVenta"]) && isset($data["fechaEntrega"]) && isset($data["tipoVenta"]) && isset($data["comentarios"]) && isset($data["detalles"])) {
    $ventas = new Venta();
    $retorno = $ventas->create_venta($data["idCliente"], $data["idVendedor"], $data["fechaVenta"], $data["fechaEntrega"], $data["tipoVenta"], $data["comentarios"], json_decode($data["detalles"], true));

    http_response_code(201); // Código 201 para creación exitosa
    header('Content-Type: application/json');
    echo json_encode(["message" => $retorno]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}