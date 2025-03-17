<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Product;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

// Inicializar variables (si no existen, se asigna null)
$nombre = $_GET["nombre"] ?? null;
$tipo = $_GET["tipo"] ?? null;

// Llamar al método sin importar si los valores están vacíos
$productos = new Product();

/**
 * Si no se proporciona ningún filtro, se listan todos los productos
 * Si se proporciona algún filtro, se listan los productos que coincidan con el filtro
 */
if ($nombre === null && $tipo === null) {
    $resultados = $productos->listar_producto_todos();
} else {
    $resultados = $productos->listar_producto_filtro($nombre, $tipo);
}

// Devolver la respuesta en formato JSON
http_response_code(200);
echo $resultados;
exit;