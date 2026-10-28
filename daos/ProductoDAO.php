<?php

class ProductoDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function guardar($producto)
    {
        $stmt = $this->db->prepare("INSERT INTO productos 
            (nombre, sku, precio_venta, stock_actual, stock_minimo, categoria_id, tipo)
            VALUES (:n, :s, :p, :sa, :sm, :c, :t)");
        $stmt->execute([
            ':n' => $producto->getNombre(),
            ':s' => $producto->getSku(),
            ':p' => $producto->getPrecioVenta(),
            ':sa' => $producto->getStockActual(),
            ':sm' => $producto->getStockMinimo(),
            ':c' => $producto->getCategoriaId(),
            ':t' => $producto->getTipo(),
        ]);
        $id = (int)$this->db->lastInsertId();
        $producto->setId($id);
        return $id;
    }

    public function actualizar($producto)
    {
        $stmt = $this->db->prepare("UPDATE productos SET 
            nombre=:n, sku=:s, precio_venta=:p, stock_actual=:sa,
            stock_minimo=:sm, categoria_id=:c, tipo=:t WHERE id=:id");
        return $stmt->execute([
            ':n' => $producto->getNombre(),
            ':s' => $producto->getSku(),
            ':p' => $producto->getPrecioVenta(),
            ':sa' => $producto->getStockActual(),
            ':sm' => $producto->getStockMinimo(),
            ':c' => $producto->getCategoriaId(),
            ':t' => $producto->getTipo(),
            ':id' => $producto->getId(),
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fila) return null;
        return $this->mapear($fila);
    }

    public function listarTodos()
    {
        $stmt = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        foreach ($filas as $fila) {
            $lista[] = $this->mapear($fila);
        }
        return $lista;
    }

    private function mapear($fila)
    {
        if ($fila['tipo'] === 'perecedero') {
            $p = new ProductoPerecedero();
        } else {
            $p = new Producto();
        }
        $p->setId($fila['id']);
        $p->setNombre($fila['nombre']);
        $p->setSku($fila['sku']);
        $p->setPrecioVenta($fila['precio_venta']);
        $p->setStockActual($fila['stock_actual']);
        $p->setStockMinimo($fila['stock_minimo']);
        $p->setCategoriaId($fila['categoria_id']);
        $p->setTipo($fila['tipo']);
        return $p;
    }
}

