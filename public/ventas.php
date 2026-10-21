<?php
require_once __DIR__ . '/../conexion.php';
requiereRol(['admin', 'vendedor']);
(new VentaController())->historial();