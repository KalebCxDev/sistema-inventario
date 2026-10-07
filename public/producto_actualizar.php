<?php
require_once __DIR__ . '/../conexion.php';
requiereLogin();
(new ProductoController())->actualizar();