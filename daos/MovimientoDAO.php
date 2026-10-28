<?php

class MovimientoDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function registrar($movimiento)
    {
        $producto = (new Producto())->buscarPorId($movimiento->getProductoId());
        if (!$producto) throw new Exception('Producto no encontrado');

        if ($movimiento->getTipo() === 'salida' && $producto->getStockActual() < $movimiento->getCantidad()) {
            throw new Exception('Stock insuficiente para la salida');
        }

        if ($movimiento->getTipo() === 'entrada') {
            $nuevo = $producto->getStockActual() + $movimiento->getCantidad();
        } else {
            $nuevo = $producto->getStockActual() - $movimiento->getCantidad();
        }

        $producto->setStockActual($nuevo);
        $producto->actualizar();

        $stmt = $this->db->prepare("INSERT INTO movimientos 
            (producto_id, tipo, cantidad) VALUES (:p, :t, :c)");
        $stmt->execute([
            ':p' => $movimiento->getProductoId(),
            ':t' => $movimiento->getTipo(),
            ':c' => $movimiento->getCantidad(),
        ]);

        $id = (int)$this->db->lastInsertId();
        $movimiento->setId($id);
        return $id;
    }

    public function listarTodos()
    {
        return $this->db->query("SELECT * FROM movimientos ORDER BY id DESC")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }
}

