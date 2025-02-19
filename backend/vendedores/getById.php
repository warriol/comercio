<?php
require_once "../autoload.php";
use class\Vendedor;

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

// Inicializar variables (si no existen, se asigna null)
$idVendedor = $_GET["idVendedor"] ?? null;

if ($idVendedor === null) {
    http_response_code(400);
    echo json_encode(["message" => "ID de vendedor no proporcionado"]);
    exit;
}

// Llamar al método sin importar si los valores están vacíos
$vendedores = new Vendedor();

$resultados = $vendedores->getById($idVendedor);

// Devolver la respuesta en formato JSON
http_response_code(200);
echo $resultados;
exit;