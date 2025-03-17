<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Vendedor;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

// Inicializar variables (si no existen, se asigna null)
$nombre = $_GET["nombre"] ?? null;
$telefono = $_GET["telefono"] ?? null;

$vendedores = new Vendedor();

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    $vendedores->debug("Método no permitido", $_SERVER["REQUEST_METHOD"]);
    http_response_code(405);
    echo json_encode(["message" => "Método no permitido"]);
    exit;
}

// Lógica para listar vendedores
if ($nombre === null && $telefono === null) {
    $resultados = $vendedores->listar_vendedor_todos();
} else {
    $resultados = $vendedores->listar_vendedor_filtro($nombre, $telefono);
}

// Devolver la respuesta en formato JSON
http_response_code(200);
echo $resultados;
exit;