<?php
require_once __DIR__ . '/../conexion.php';
requiereLogin();
(new AjaxController())->guardar_cliente();