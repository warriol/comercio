<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Client;
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

if (isset($data["nombre"]) && isset($data["apellido"]) && isset($data["telefono"]) && isset($data["correo"])) {
    $clientes = new Client();
    $retorno = $clientes->create_cliente($data["nombre"], $data["apellido"], $data["telefono"], $data["correo"]);

    header($retorno['header']);
    echo json_encode(['message' => $retorno['message']]);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}