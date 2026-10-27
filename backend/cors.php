<?php
header("Content-Type: application/json");

$allowed_origins = [
    "http://localhost",
    "https://localhost",
    "http://127.0.0.1",
    "https://127.0.0.1",
    "https://frontend.panaderia.warriol.com.uy",
    "https://backend.panaderia.warriol.com.uy"
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
 $is_local_origin = (bool) preg_match('/^https?:\/\/(localhost|127\.0\.0\.1)(:\d+)?$/', $origin);

if ($origin !== '' && (in_array($origin, $allowed_origins, true) || $is_local_origin)) {
    header("Access-Control-Allow-Origin: " . $origin);
    header("Vary: Origin");
}

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Manejo de preflight CORS
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit;
}