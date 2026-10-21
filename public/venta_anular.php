<?php
require_once __DIR__ . '/../conexion.php';
requiereRol('admin');
(new VentaController())->anular();