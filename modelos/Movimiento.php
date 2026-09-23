<?php

class Movimiento extends Model
{
    private $productoId;
    private $tipo;
    private $cantidad;

    public function setProductoId($v)
    {
        if (!$v) throw new Exception('Debes seleccionar un producto');
        $this->productoId = (int)$v;
    }

    public function setTipo($v)
    {
        if (!in_array($v, ['entrada', 'salida'])) {
            throw new Exception('Tipo de movimiento inválido');
        }
        $this->tipo = $v;
    }

    public function setCantidad($v)
    {
        if ($v <= 0) throw new Exception('La cantidad debe ser mayor a 0');
        $this->cantidad = (int)$v;
    }

    public function registrar()
    {
        $producto = (new Producto())->buscarPorId($this->productoId);
        if (!$producto) throw new Exception('Producto no encontrado');

        if ($this->tipo === 'salida' && $producto->getStockActual() < $this->cantidad) {
            throw new Exception('Stock insuficiente para la salida');
        }

        if ($this->tipo === 'entrada') {
            $nuevo = $producto->getStockActual() + $this->cantidad;
        } else {
            $nuevo = $producto->getStockActual() - $this->cantidad;
        }

        $producto->setStockActual($nuevo);
        $producto->actualizar();

        $stmt = $this->db->prepare("INSERT INTO movimientos 
            (producto_id, tipo, cantidad) VALUES (:p, :t, :c)");
        $stmt->execute([
            ':p' => $this->productoId,
            ':t' => $this->tipo,
            ':c' => $this->cantidad,
        ]);

        return $this->db->lastInsertId();
    }

    public function listarTodos()
    {
        return $this->db->query("SELECT * FROM movimientos ORDER BY id DESC")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }
}