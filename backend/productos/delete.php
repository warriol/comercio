<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Product;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

// Inicializar variables (si no existen, se asigna null)
$idProducto = $_GET["idProducto"] ?? null;

if ($idProducto === null) {
    http_response_code(400);
    echo json_encode(["message" => "ID de producto no proporcionado"]);
    exit;
}

// Llamar al método sin importar si los valores están vacíos
$productos = new Product();

$respuesta = $productos->delete($idProducto);

// Devolver la respuesta en formato JSON
http_response_code(200);
echo json_encode(["message" => $respuesta]);
exit;