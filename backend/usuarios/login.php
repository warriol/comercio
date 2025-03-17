<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\User;

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["email"]) && isset($data["password"])) {
    $user = new User();
    $retorno = $user->login($data["email"], $data["password"]);

    if ($retorno['error']) {
        http_response_code(401);
        echo json_encode(['error' => $retorno['error']]);
    } else {
        echo json_encode(['message' => 'Login successful']);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Bad Request"]);
}