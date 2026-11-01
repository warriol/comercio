<?php
session_start();
session_destroy();
$host = strtolower(explode(':', $_SERVER['HTTP_HOST'] ?? '')[0]);
$isLocalhost = in_array($host, ['localhost', '127.0.0.1'], true);
$loginPath = $isLocalhost ? '/comercio/frontend/index.php' : '/index.php';
$reason = isset($_GET['reason']) ? '?error=' . rawurlencode($_GET['reason']) : '';
header('Location: ' . $loginPath . $reason);
exit();
