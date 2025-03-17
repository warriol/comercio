<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Client;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

// Instanciar la clase Client
$clientes = new Client();

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    $clientes->debug("Método no permitido", $_SERVER["REQUEST_METHOD"]);
    http_response_code(405);
    echo json_encode(["message" => "Método no permitido"]);
    exit;
}

// Inicializar variables (si no existen, se asigna null)
$nombre = $_GET["nombre"] ?? null;
$apellido = $_GET["apellido"] ?? null;
$telefono = $_GET["telefono"] ?? null;
$correo = $_GET["correo"] ?? null;

// Lógica para listar clientes
if ($nombre === null && $apellido === null && $telefono === null && $correo === null) {
    $resultados = $clientes->listar_cliente_todos();
} else {
    $resultados = $clientes->listar_cliente_filtro($nombre, $apellido, $telefono, $correo);
}

// Devolver la respuesta en formato JSON
http_response_code(200);
echo $resultados;
exit;
