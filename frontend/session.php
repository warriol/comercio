<?php
// session.php
session_start();
$token = $_SESSION['token'] ?? '';
$tokenParts = is_string($token) ? explode('.', preg_replace('/^Bearer\s+/i', '', $token)) : [];
$tokenPayload = [];
if (count($tokenParts) === 3) {
    $payload = strtr($tokenParts[1], '-_', '+/');
    $payload .= str_repeat('=', (4 - strlen($payload) % 4) % 4);
    $decodedPayload = base64_decode($payload, true);
    $tokenPayload = is_string($decodedPayload) ? json_decode($decodedPayload, true) : [];
}

if (
    !isset($_SESSION['user']) ||
    !is_string($token) ||
    count($tokenParts) !== 3 ||
    !is_array($tokenPayload) ||
    !isset($tokenPayload['exp']) ||
    !is_numeric($tokenPayload['exp']) ||
    (int) $tokenPayload['exp'] <= time()
) {
    session_unset();
    $host = strtolower(explode(':', $_SERVER['HTTP_HOST'] ?? '')[0]);
    $isLocalhost = in_array($host, ['localhost', '127.0.0.1'], true);
    $loginPath = $isLocalhost ? '/comercio/frontend/index.php' : '/index.php';
    header('Location: ' . $loginPath . '?error=session_expired');
    exit();
}

$_SESSION['isAdmin'] = (int) ($tokenPayload['isAdmin'] ?? 0) === 1;
?>