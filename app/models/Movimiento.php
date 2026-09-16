<?php

class Movimiento extends Model
{
    private $id;
    private $productoId;
    private $tipo;
    private $cantidad;

    public function getId() { return $this->id; }
    public function getProductoId() { return $this->productoId; }
    public function getTipo() { return $this->tipo; }
    public function getCantidad() { return $this->cantidad; }

    public function setProductoId($id)
    {
        if (!$id) {
            throw new Exception('Debes seleccionar un producto');
        }
        $this->productoId = (int)$id;
    }

    public function setTipo($tipo)
    {
        if ($tipo !== 'entrada' && $tipo !== 'salida') {
            throw new Exception('Tipo de movimiento inválido');
        }
        $this->tipo = $tipo;
    }

    public function setCantidad($cantidad)
    {
        if ($cantidad <= 0) {
            throw new Exception('La cantidad debe ser mayor a 0');
        }
        $this->cantidad = (int)$cantidad;
    }

    public function registrar()
    {
        $productoModel = new Producto();
        $producto = $productoModel->buscarPorId($this->productoId);

        if (!$producto) {
            throw new Exception('Producto no encontrado');
        }

        if ($this->tipo === 'salida' && $producto->getStockActual() < $this->cantidad) {
            throw new Exception('Stock insuficiente para la salida');
        }

        if ($this->tipo === 'entrada') {
            $nuevoStock = $producto->getStockActual() + $this->cantidad;
        } else {
            $nuevoStock = $producto->getStockActual() - $this->cantidad;
        }

        $producto->setStockActual($nuevoStock);
        $producto->actualizar();

        $stmt = $this->db->prepare("INSERT INTO movimientos (producto_id, tipo, cantidad) VALUES (:p, :t, :c)");
        $stmt->execute([
            ':p' => $this->productoId,
            ':t' => $this->tipo,
            ':c' => $this->cantidad
        ]);

        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function listarTodos()
    {
        $stmt = $this->db->query("SELECT * FROM movimientos ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}