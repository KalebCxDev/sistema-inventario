<?php
require_once __DIR__ . '/../conexion.php';
requiereRol(['admin', 'recepcionista']);
(new CategoriaController())->guardar();