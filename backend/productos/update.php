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

// Capturar datos enviados en FormData (los valores vienen en $_POST)
$idProducto = $_POST["idProducto"] ?? null;
$nombre = $_POST["nombre"] ?? null;
$precio = $_POST["precio"] ?? null;
$precioEsp = $_POST["precioEsp"] ?? null;
$tipo = $_POST["tipo"] ?? null;

// Validación del ID de producto
if (!$idProducto) {
    http_response_code(400);
    echo json_encode(["message" => "ID de producto no proporcionado" . $_POST["idProducto"]]);
    exit;
}

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

if (empty($imagen)) {
    $imagen = ''; //obtenerImagenActual($idProducto);
}

// Llamar al método
$productos = new Product();
$resp = $productos->update_producto($idProducto, $nombre, $imagen, $precio, $precioEsp, $tipo);

// Devolver la respuesta en formato JSON
http_response_code(200);
echo json_encode(["message" =>  $resp['message']]);
exit;