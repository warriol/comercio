<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\Client;

$clientes = new Client();

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    $clientes->debug("Method Not Allowed", $_SERVER["REQUEST_METHOD"]);
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$resultados = $clientes->listar_clientes_con_ventas_credito();

http_response_code(200);
echo $resultados;
exit;
