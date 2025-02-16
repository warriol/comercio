<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\Client;

if ($_SERVER["REQUEST_METHOD"] != "PUT") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

// Inicializar variables (si no existen, se asigna null)
$idCliente = $_GET["idCliente"] ?? null;
$nombre = $_GET["nombre"] ?? null;
$apellido = $_GET["apellido"] ?? null;
$telefono = $_GET["telefono"] ?? null;
$correo = $_GET["correo"] ?? null;

// Llamar al método sin importar si los valores están vacíos
$clientes = new Client();

if ($idCliente === null) {
    http_response_code(400);
    echo json_encode(["message" => "ID de cliente no proporcionado"]);
    exit;
}

$clientes->update_cliente($idCliente, $nombre, $apellido, $telefono, $correo);

// Devolver la respuesta en formato JSON
http_response_code(200);
echo json_encode(["message" => "Cliente actualizado correctamente"]);
exit;