<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://localhost");
header("Access-Control-Allow-Origin: https://192.168.1.25");
//header("Access-Control-Allow-Origin: *"); // warriol.site");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Manejo de preflight CORS
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit;
}