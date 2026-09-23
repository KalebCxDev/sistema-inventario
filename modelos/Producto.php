<?php

class Producto extends Model
{
    private $id;
    private $nombre;
    private $sku;
    private $precioVenta;
    private $stockActual;
    private $stockMinimo;
    private $categoriaId;
    private $tipo;

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getSku() { return $this->sku; }
    public function getPrecioVenta() { return $this->precioVenta; }
    public function getStockActual() { return $this->stockActual; }
    public function getStockMinimo() { return $this->stockMinimo; }
    public function getCategoriaId() { return $this->categoriaId; }
    public function getTipo() { return $this->tipo; }

    public function setId($v) { $this->id = (int)$v; }

    public function setNombre($v)
    {
        if (trim($v) === '') throw new Exception('El nombre no puede estar vacío');
        $this->nombre = trim($v);
    }

    public function setSku($v)
    {
        if (trim($v) === '') throw new Exception('El SKU no puede estar vacío');
        $this->sku = strtoupper(trim($v));
    }

    public function setPrecioVenta($v)
    {
        if ($v < 0) throw new Exception('El precio no puede ser negativo');
        $this->precioVenta = (float)$v;
    }

    public function setStockActual($v)
    {
        if ($v < 0) throw new Exception('El stock no puede ser negativo');
        $this->stockActual = (int)$v;
    }

    public function setStockMinimo($v)
    {
        if ($v < 0) throw new Exception('El stock mínimo no puede ser negativo');
        $this->stockMinimo = (int)$v;
    }

    public function setCategoriaId($v)
    {
        $this->categoriaId = ($v === '' || $v === null) ? null : (int)$v;
    }

    public function setTipo($v)
    {
        if (!in_array($v, ['estandar', 'perecedero'])) {
            throw new Exception('Tipo inválido');
        }
        $this->tipo = $v;
    }

    public function llenar($datos)
    {
        $this->setNombre($datos['nombre'] ?? '');
        $this->setSku($datos['sku'] ?? '');
        $this->setPrecioVenta($datos['precio_venta'] ?? 0);
        $this->setStockActual($datos['stock_actual'] ?? 0);
        $this->setStockMinimo($datos['stock_minimo'] ?? 0);
        $this->setCategoriaId($datos['categoria_id'] ?? null);
        $this->setTipo($datos['tipo'] ?? 'estandar');
    }

    public function stockCritico()
    {
        return $this->stockActual <= $this->stockMinimo;
    }

    public function descripcion()
    {
        return "Producto: {$this->nombre}";
    }

    public function detallesExtra()
    {
        return '-';
    }

    public function guardar()
    {
        $stmt = $this->db->prepare("INSERT INTO productos 
            (nombre, sku, precio_venta, stock_actual, stock_minimo, categoria_id, tipo)
            VALUES (:n, :s, :p, :sa, :sm, :c, :t)");
        $stmt->execute([
            ':n' => $this->nombre,
            ':s' => $this->sku,
            ':p' => $this->precioVenta,
            ':sa' => $this->stockActual,
            ':sm' => $this->stockMinimo,
            ':c' => $this->categoriaId,
            ':t' => $this->tipo,
        ]);
        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function actualizar()
    {
        $stmt = $this->db->prepare("UPDATE productos SET 
            nombre=:n, sku=:s, precio_venta=:p, stock_actual=:sa,
            stock_minimo=:sm, categoria_id=:c, tipo=:t WHERE id=:id");
        return $stmt->execute([
            ':n' => $this->nombre,
            ':s' => $this->sku,
            ':p' => $this->precioVenta,
            ':sa' => $this->stockActual,
            ':sm' => $this->stockMinimo,
            ':c' => $this->categoriaId,
            ':t' => $this->tipo,
            ':id' => $this->id,
        ]);
    }

    public function eliminar()
    {
        return $this->db->prepare("DELETE FROM productos WHERE id=:id")
                        ->execute([':id' => $this->id]);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id=:id");
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

    public function listarCriticos()
    {
        $criticos = [];
        foreach ($this->listarTodos() as $p) {
            if ($p->stockCritico()) {
                $criticos[] = $p;
            }
        }
        return $criticos;
    }

    protected function mapear($fila)
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