<?php

require_once __DIR__ . '/../core/bootstrap.php';

$rutas = [
    'home' => ['HomeController', 'index'],
    'index' => ['ProductoController', 'index'],
    'crear' => ['ProductoController', 'crear'],
    'guardar' => ['ProductoController', 'guardar'],
    'editar' => ['ProductoController', 'editar'],
    'actualizar' => ['ProductoController', 'actualizar'],
    'eliminar' => ['ProductoController', 'eliminar'],
    'categorias' => ['CategoriaController', 'index'],
    'categoria_guardar' => ['CategoriaController', 'guardar'],
    'categoria_eliminar' => ['CategoriaController', 'eliminar'],
    'movimientos' => ['MovimientoController', 'index'],
    'movimiento_guardar' => ['MovimientoController', 'guardar'],
    'alertas' => ['AlertaController', 'index'],
];

$accion = $_GET['accion'] ?? 'home';
[$controlador, $metodo] = $rutas[$accion] ?? $rutas['home'];

(new $controlador())->$metodo();