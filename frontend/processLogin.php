<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = hash('sha512', $_POST['password']);

    $URL_BASE = ($_SERVER['HTTP_HOST'] == 'localhost') ? 'https://localhost/' : 'https://192.168.1.9/';

    $url = $URL_BASE . 'comercio/backend/usuarios/login.php';

    $data = json_encode(['email' => $email, 'password' => $password]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['error'])) {
        echo $result['error'];
    } else {
        $_SESSION['user'] = $email;
        header('Location: dashboard.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
