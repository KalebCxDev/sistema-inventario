<?php
require_once __DIR__ . '/../conexion.php';
requiereLogin();

$accion = $_GET['accion'] ?? ($_POST['accion'] ?? 'index');
$controller = new CategoriaController();

switch ($accion) {
    case 'guardar':
        requiereRol(['admin', 'recepcionista']);
        $controller->guardar();
        break;
    case 'eliminar':
        requiereRol('admin');
        $controller->eliminar();
        break;
    default:
        $controller->index();
        break;
}
