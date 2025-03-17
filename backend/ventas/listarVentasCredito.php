<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Venta;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

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
    echo json_encode($result);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}