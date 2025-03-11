<?php
require_once "../cors.php";
require_once "../autoload.php";
use class\Client;
use class\Venta;

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit;
}

$clientes = new Client();
$ventas = new Venta();

$resultados = $clientes->listar_clientes_con_ventas_credito();

http_response_code(200);
echo json_encode($resultados);
exit;
