<?php
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("HTTP/1.1 200 OK");
    exit;
}

header("Content-Type: application/json");
require_once "autoload.php"; // Cargar dependencias

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = trim($_SERVER['REQUEST_URI'], "/");

// Eliminar "backend" de la URL si es necesario
$baseFolder = "backend/";
if (strpos($requestUri, $baseFolder) === 0) {
    $requestUri = substr($requestUri, strlen($baseFolder));
}

$parts = explode("/", $requestUri);

if (count($parts) < 2) {
    echo json_encode(["error" => "Ruta no válida"]);
    http_response_code(400);
    exit;
}

$entidad = $parts[0];    // Ejemplo: clientes
$accion = $parts[1];     // Ejemplo: crear

// Construcción de la ruta al archivo correspondiente
$archivo = __DIR__ . "/$entidad/$accion.php";

if (file_exists($archivo)) {
    require $archivo;
} else {
    echo json_encode(["error" => "Recurso no encontrado"]);
    http_response_code(404);
}

