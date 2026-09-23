<?php

// carga la configuracion y crea la conexion PDO
require_once __DIR__ . '/config.php';

function conectar()
{
    global $db_host, $db_nombre, $db_usuario, $db_password;
    $dsn = "mysql:host=$db_host;dbname=$db_nombre;charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $db_usuario, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
}

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = conectar();
    }
}

require_once __DIR__ . '/modelos/Producto.php';
require_once __DIR__ . '/modelos/ProductoPerecedero.php';
require_once __DIR__ . '/modelos/Categoria.php';
require_once __DIR__ . '/modelos/Movimiento.php';

require_once __DIR__ . '/controladores/ProductoController.php';
require_once __DIR__ . '/controladores/CategoriaController.php';
require_once __DIR__ . '/controladores/MovimientoController.php';
require_once __DIR__ . '/controladores/HomeController.php';
require_once __DIR__ . '/controladores/AlertaController.php';