<?php
require_once __DIR__ . '/../conexion.php';

$accion = $_GET['accion'] ?? 'login';

if ($accion === 'autenticar') {
    (new AuthController())->autenticar();
} else {
    (new AuthController())->login();
}