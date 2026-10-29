<?php
require_once __DIR__ . '/../conexion.php';
requiereRol(['admin', 'recepcionista']);

$accion = $_GET['accion'] ?? ($_POST['accion'] ?? 'index');
$controller = new MovimientoController();

switch ($accion) {
    case 'guardar':
        $controller->guardar();
        break;
    default:
        $controller->index();
        break;
}
