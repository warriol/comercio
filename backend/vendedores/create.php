<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Vendedor;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["nombre"]) && isset($data["telefono"])) {
    $vendedores = new Vendedor();
    $retorno = $vendedores->create_vendedor($data["nombre"], $data["telefono"]);

    header($retorno['header']);
    echo json_encode(['message' => $retorno['message']]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}