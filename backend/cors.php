<?php
header("Content-Type: application/json");

$allowed_origins = [
    "https://frontend.panaderia.warriol.site",
    "https://backend.panaderia.warriol.site"
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Manejo de preflight CORS
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit;
}