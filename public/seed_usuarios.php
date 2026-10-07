<?php
require_once __DIR__ . '/../conexion.php';

$usuarios = [
    ['Administrador',  'admin',          'admin123',  'admin'],
    ['Vendedor 1',     'vendedor',       'vende123',  'vendedor'],
    ['Recepcionista',  'recepcionista',  'recepc123', 'recepcionista'],
];

foreach ($usuarios as $datos) {
    try {
        $u = new Usuario();
        $u->setNombre($datos[0]);
        $u->setUsuario($datos[1]);
        $u->setPassword($datos[2]);
        $u->setRol($datos[3]);
        $u->guardar();
        echo "Creado: {$datos[1]} ({$datos[3]})<br>";
    } catch (Exception $e) {
        echo "Ya existía o error con {$datos[1]}: " . $e->getMessage() . "<br>";
    }
}