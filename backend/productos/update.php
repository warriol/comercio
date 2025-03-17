<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\Product;
use class\Auth;

// Verificar si el usuario está autenticado
$auth = new Auth();
$auth->estaAutenticado();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

// Verificar si se simuló un método PUT
$method = $_POST["_method"] ?? "POST";

if ($method !== "PUT") {
    http_response_code(400);
    echo json_encode(["message" => "Método no permitido"]);
    exit;
}

// Capturar datos enviados en FormData (los valores vienen en $_POST)
$idProducto = $_POST["idProducto"] ?? null;
$nombre = $_POST["nombre"] ?? null;
$precio = $_POST["precio"] ?? null;
$precioEsp = $_POST["precioEsp"] ?? null;
$tipo = $_POST["tipo"] ?? null;

// Manejo de archivo (imagen)
$imagen = $_FILES["imagen"]["name"] ?? null;

if ($imagen) {
    $target_dir = "../imagenes/";
    $new_image_name = uniqid() . '.' . pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    $target_file = $target_dir . $new_image_name;

    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        http_response_code(500);
        echo json_encode(["message" => "Error al subir la imagen"]);
        exit;
    }
    $imagen = $new_image_name; // Guarda el nuevo nombre del archivo
}

// Validación del ID de producto
if (!$idProducto) {
    http_response_code(400);
    echo json_encode(["message" => "ID de producto es requerido"]);
    exit;
}

if (empty($imagen)) {
    // Aquí, puedes obtener el valor actual de la imagen desde la base de datos
    $imagen = ''; //obtenerImagenActual($idProducto);  // Esta función depende de tu implementación
}

// Llamar al método sin importar si los valores están vacíos
$productos = new Product();

$resp = $productos->update_producto($idProducto, $nombre, $imagen, $precio, $precioEsp, $tipo);

// Devolver la respuesta en formato JSON
http_response_code(200);
echo json_encode(["message" => $resp]);
exit;