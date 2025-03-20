<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Vendedor;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

if ($_SERVER["REQUEST_METHOD"] != "PUT") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

// Inicializar variables (si no existen, se asigna null)
$idVendedor = $_GET["idVendedor"] ?? null;
$nombre = $_GET["nombre"] ?? null;
$telefono = $_GET["telefono"] ?? null;

if ($idVendedor === null) {
    http_response_code(400);
    echo json_encode(["message" => "ID de vendedor no proporcionado"]);
    exit;
}

// Llamar al método sin importar si los valores están vacíos
$vendedores = new Vendedor();
$vendedores->update_vendedor($idVendedor, $nombre, $telefono);

// Devolver la respuesta en formato JSON
http_response_code(200);
echo json_encode(["message" => "Vendedor actualizado correctamente"]);
exit;