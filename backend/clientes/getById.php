<?php
require_once "../autoload.php";
use class\Client;

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

// Inicializar variables (si no existen, se asigna null)
$idCliente = $_GET["idCliente"] ?? null;

if ($idCliente === null) {
    http_response_code(400);
    echo json_encode(["message" => "ID de cliente no proporcionado"]);
    exit;
}

// Llamar al método sin importar si los valores están vacíos
$clientes = new Client();

$resultados = $clientes->getById($idCliente);

// Devolver la respuesta en formato JSON
http_response_code(200);
echo $resultados;
exit;