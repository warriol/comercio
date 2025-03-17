<?php
session_start();
session_destroy();
$URL_BASE = ($_SERVER['HTTP_HOST'] == 'localhost') ? 'https://localhost/' : 'https://backend.panaderia.warriol.site/';
header('Location: '.$URL_BASE.'index.php');
exit();
