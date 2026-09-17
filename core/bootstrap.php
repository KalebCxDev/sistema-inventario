<?php

spl_autoload_register(function ($class) {
    foreach ([__DIR__ . '/', __DIR__ . '/../app/models/', __DIR__ . '/../app/controllers/'] as $dir) {
        if (file_exists($file = $dir . $class . '.php')) {
            require_once $file;
            return;
        }
    }
});

class Database
{
    private static $instance = null;
    private $connection;

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

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() { return $this->connection; }
}

abstract class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
}
