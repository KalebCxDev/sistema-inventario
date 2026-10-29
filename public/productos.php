<?php
require_once __DIR__ . '/../conexion.php';
requiereLogin();

$accion = $_GET['accion'] ?? ($_POST['accion'] ?? 'index');
$controller = new ProductoController();

switch ($accion) {
    case 'crear':
        requiereRol(['admin', 'recepcionista']);
        $controller->crear();
        break;
    case 'guardar':
        requiereRol(['admin', 'recepcionista']);
        $controller->guardar();
        break;
    case 'editar':
        requiereRol(['admin', 'recepcionista']);
        $controller->editar();
        break;
    case 'actualizar':
        requiereRol(['admin', 'recepcionista']);
        $controller->actualizar();
        break;
    case 'eliminar':
        requiereRol('admin');
        $controller->eliminar();
        break;
    default:
        $controller->index();
        break;
}
