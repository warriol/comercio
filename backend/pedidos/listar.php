<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Pedido;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$fechaPedido = $_GET['fechaPedido'] ?? null;

if ($fechaPedido) {
    $pedidos = new Pedido();
    $result = $pedidos->listar_pedidos_por_fecha($fechaPedido);

    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}