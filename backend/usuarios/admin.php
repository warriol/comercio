<?php
require_once "../cors.php";
require_once "../autoload.php";

use class\User;

$user = new User();
$user->exigirAdministrador();
$method = $_SERVER["REQUEST_METHOD"];

try {
    if ($method === "GET") {
        echo json_encode($user->listarUsuarios());
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    if (!is_array($data)) {
        http_response_code(400);
        echo json_encode(["message" => "Bad Request"]);
        exit;
    }

    if ($method === "POST") {
        if (empty($data["email"]) || empty($data["nombre"]) || empty($data["password"])) {
            http_response_code(400);
            echo json_encode(["message" => "Email, nombre y contraseña son obligatorios"]);
            exit;
        }
        $user->crearUsuario(
            trim($data["email"]),
            trim($data["nombre"]),
            $data["password"],
            !empty($data["isAdmin"])
        );
        http_response_code(201);
        echo json_encode(["message" => "Usuario creado"]);
        exit;
    }

    if ($method === "PUT") {
        if (!isset($data["id"], $data["email"], $data["nombre"])) {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
            exit;
        }
        $user->actualizarUsuario(
            (int) $data["id"],
            trim($data["email"]),
            trim($data["nombre"]),
            isset($data["password"]) ? $data["password"] : null,
            !empty($data["isAdmin"])
        );
        echo json_encode(["message" => "Usuario actualizado"]);
        exit;
    }

    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
} catch (\PDOException $exception) {
    \Debug::exception("users.admin.database_error", $exception);
    http_response_code(400);
    echo json_encode(["message" => "No se pudo guardar el usuario"]);
}
