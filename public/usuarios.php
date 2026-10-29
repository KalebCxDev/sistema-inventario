<?php
require_once __DIR__ . '/../conexion.php';
requiereRol('admin');

$accion = $_GET['accion'] ?? ($_POST['accion'] ?? 'index');
$controller = new UsuarioController();

switch ($accion) {
    case 'crear':
        $controller->crear();
        break;
    case 'guardar':
        $controller->guardar();
        break;
    case 'editar':
        $controller->editar();
        break;
    case 'actualizar':
        $controller->actualizar();
        break;
    case 'eliminar':
        $controller->eliminar();
        break;
    default:
        $controller->index();
        break;
}
