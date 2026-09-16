<?php

require_once __DIR__ . '/../core/autoload.php';

$accion = $_GET['accion'] ?? 'index';
$controller = new ProductoController();

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