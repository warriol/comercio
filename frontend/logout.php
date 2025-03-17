<?php
session_start();
session_destroy();
$URL_BASE = ($_SERVER['HTTP_HOST'] == 'localhost') ? 'https://localhost/' : 'https://192.168.1.9/';
header('Location: '.$URL_BASE.'comercio/frontend/index.php');
exit();
