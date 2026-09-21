<?php

// clase base de todos los productos, hereda de Model
class Producto extends Model
{
    // propiedades privadas, nadie las toca desde afuera
    private $id, $nombre, $sku, $precioVenta, $stockActual, $stockMinimo, $categoriaId, $tipo;

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getSku() { return $this->sku; }
    public function getPrecioVenta() { return $this->precioVenta; }
    public function getStockActual() { return $this->stockActual; }
    public function getStockMinimo() { return $this->stockMinimo; }
    public function getCategoriaId() { return $this->categoriaId; }
    public function getTipo() { return $this->tipo; }

    public function setNombre($v)
    {
        if (trim($v) === '') throw new Exception('El nombre no puede estar vacío');
        $this->nombre = trim($v);
    }

    // el sku se guarda en mayusculas para evitar duplicados
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

    // solo acepta los 3 tipos validos
    public function setTipo($v)
    {
        if (!in_array($v, ['estandar', 'fragil', 'perecedero'])) throw new Exception('Tipo inválido');
        $this->tipo = $v;
    }

    public function setId($v) { $this->id = (int)$v; }

    // recibe el array del formulario y llama a cada setter
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

    public function stockCritico() { return $this->stockActual <= $this->stockMinimo; }
    public function descripcion() { return "Producto: {$this->nombre}"; }
    public function detallesExtra() { return '-'; }

    public function guardar()
    {
        $stmt = $this->db->prepare("INSERT INTO productos (nombre, sku, precio_venta, stock_actual, stock_minimo, categoria_id, tipo)
                                    VALUES (:n, :s, :p, :sa, :sm, :c, :t)");
        $stmt->execute([
            ':n' => $this->nombre, ':s' => $this->sku, ':p' => $this->precioVenta,
            ':sa' => $this->stockActual, ':sm' => $this->stockMinimo,
            ':c' => $this->categoriaId, ':t' => $this->tipo
        ]);
        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function actualizar()
    {
        $stmt = $this->db->prepare("UPDATE productos SET nombre=:n, sku=:s, precio_venta=:p,
                                    stock_actual=:sa, stock_minimo=:sm, categoria_id=:c, tipo=:t WHERE id=:id");
        return $stmt->execute([
            ':n' => $this->nombre, ':s' => $this->sku, ':p' => $this->precioVenta,
            ':sa' => $this->stockActual, ':sm' => $this->stockMinimo,
            ':c' => $this->categoriaId, ':t' => $this->tipo, ':id' => $this->id
        ]);
    }

    public function eliminar()
    {
        return $this->db->prepare("DELETE FROM productos WHERE id=:id")->execute([':id' => $this->id]);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id=:id");
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? $this->mapear($fila) : null;
    }

    public function listarTodos()
    {
        $stmt = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
        return array_map([$this, 'mapear'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // filtra en php para respetar el stockCritico de cada tipo
    public function listarCriticos()
    {
        return array_values(array_filter($this->listarTodos(), fn($p) => $p->stockCritico()));
    }

    // convierte una fila de la bd en el objeto correcto segun el tipo (polimorfismo)
    private function mapear($fila)
    {
        $clase = match ($fila['tipo']) {
            'fragil' => 'ProductoFragil',
            'perecedero' => 'ProductoPerecedero',
            default => 'ProductoEstandar',
        };

        $p = new $clase();
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