<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Client;
use class\Auth;

$auth = new Auth();
$auth->estaAutenticado();

if ($_SERVER["REQUEST_METHOD"] != "PUT") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$idCliente = $_GET["idCliente"] ?? null;
$nombre = $_GET["nombre"] ?? null;
$apellido = $_GET["apellido"] ?? null;
$telefono = $_GET["telefono"] ?? null;
$correo = $_GET["correo"] ?? null;

if ($idCliente === null) {
    http_response_code(400);
    echo json_encode(["message" => "ID de cliente no proporcionado"]);
    exit;
}

$clientes = new Client();
$retorno = $clientes->update_cliente($idCliente, $nombre, $apellido, $telefono, $correo);

http_response_code(200);
echo json_encode($retorno);
exit;