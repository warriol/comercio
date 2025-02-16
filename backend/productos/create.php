<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\Product;

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$data = $_POST;

if (isset($data["nombre"]) && isset($_FILES["imagen"]) && isset($data["precio"]) && isset($data["precioEsp"]) && isset($data["tipo"])) {
    $target_dir = "../imagenes/";
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $new_image_name = uniqid() . '.' . pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    $target_file = $target_dir . $new_image_name;
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        $imagen = $new_image_name; // Guarda el nuevo nombre del archivo
        $productos = new Product();
        $retorno = $productos->create_producto($data["nombre"], $imagen, $data["precio"], $data["precioEsp"], $data["tipo"]);

        // Establecer el código de respuesta correctamente
        http_response_code(201); // Código 201 para creación exitosa

        // Enviar la respuesta JSON
        header('Content-Type: application/json');
        echo json_encode(["message" => $retorno]);
    } else {
        http_response_code(500); // Código 500 para error en la subida de imagen
        header('Content-Type: application/json');
        echo json_encode(["message" => "Error al subir la imagen"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}