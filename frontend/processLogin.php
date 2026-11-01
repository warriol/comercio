<?php
session_start();
require_once __DIR__ . '/../backend/class/Debug.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = hash('sha512', $_POST['password']);
    Debug::log('frontend.login.request', [
        'email' => $email,
        'password_length' => strlen($password)
    ]);

    $host = strtolower(explode(':', $_SERVER['HTTP_HOST'] ?? '')[0]);
    $isLocalhost = in_array($host, ['localhost', '127.0.0.1'], true);
    $URL_BASE = $isLocalhost
        ? 'https://localhost/comercio/backend/'
        : 'https://backend.panaderia.warriol.com.uy/';

    $url = $URL_BASE . 'usuarios/login.php';

    $data = json_encode(['email' => $email, 'password' => $password]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    if ($isLocalhost) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $result = json_decode($response, true);

    if ($response === false || $curlError !== '' || !is_array($result)) {
        Debug::log('frontend.login.connection_error', [
            'curl_error' => $curlError,
            'http_code' => $httpCode,
            'response_length' => is_string($response) ? strlen($response) : null
        ]);
        echo $curlError !== ''
            ? 'No se pudo conectar con la API de autenticación: ' . $curlError
            : 'La API de autenticación devolvió una respuesta inválida.';
    } elseif (isset($result['error'])) {
        Debug::log('frontend.login.rejected', [
            'http_code' => $httpCode,
            'error' => $result['error']
        ]);
        echo $result['error'];
    } elseif ($httpCode < 200 || $httpCode >= 300 || empty($result['token'])) {
        Debug::log('frontend.login.invalid_response', ['http_code' => $httpCode]);
        echo 'La API no devolvió un token de autenticación válido.';
    } else {
        Debug::log('frontend.login.accepted', ['http_code' => $httpCode]);
        $_SESSION['user'] = $email;
        $_SESSION['token'] = $result['token'];
        header('Location: dashboard.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
