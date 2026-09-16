<?php

require_once __DIR__ . '/../core/autoload.php';

$db = Database::getInstance()->getConnection();

echo "<h1>Sistema de Inventario</h1>";
echo "<p>Conexión a la base de datos: <strong>OK</strong></p>";