<?php

// cargamos las clases automaticamente desde estas carpetas
spl_autoload_register(function ($class) {
    foreach ([__DIR__ . '/', __DIR__ . '/../app/models/', __DIR__ . '/../app/controllers/'] as $dir) {
        if (file_exists($file = $dir . $class . '.php')) {
            require_once $file;
            return;
        }
    }
});

// clase singleton para la conexion a mysql
class Database
{
    private static $instance = null;
    private $connection;

    // constructor privado para que nadie pueda hacer new Database()
    private function __construct()
    {
        $c = require __DIR__ . '/../config/database.php';
        $dsn = "mysql:host={$c['host']};dbname={$c['dbname']};charset={$c['charset']}";
        try {
            $this->connection = new PDO($dsn, $c['user'], $c['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    // devuelve siempre la misma conexion (singleton)
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() { return $this->connection; }
}

// clase base abstracta q da la conexion a todos los modelos
abstract class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
}