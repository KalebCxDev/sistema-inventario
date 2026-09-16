<?php

require_once __DIR__ . '/../core/autoload.php';

$accion = $_GET['accion'] ?? 'index';

switch ($accion) {
    case 'crear':
    case 'guardar':
    case 'editar':
    case 'actualizar':
    case 'eliminar':
        $controller = new ProductoController();
        $controller->$accion();
        break;

    case 'categorias':
        $controller = new CategoriaController();
        $controller->index();
        break;
    case 'categoria_crear':
        $controller = new CategoriaController();
        $controller->crear();
        break;
    case 'categoria_guardar':
        $controller = new CategoriaController();
        $controller->guardar();
        break;
    case 'categoria_eliminar':
        $controller = new CategoriaController();
        $controller->eliminar();
        break;

    default:
        $controller = new ProductoController();
        $controller->index();
        break;
}