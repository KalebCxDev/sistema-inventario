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

    public function setId($id) { $this->id = (int)$id; }

    public function setNombre($nombre)
    {
        $nombre = trim($nombre);
        if ($nombre === '') {
            throw new Exception('El nombre no puede estar vacío');
        }
        $this->nombre = $nombre;
    }

    public function setSku($sku)
    {
        $sku = trim($sku);
        if ($sku === '') {
            throw new Exception('El SKU no puede estar vacío');
        }
        $this->sku = strtoupper($sku);
    }

    public function setPrecioVenta($precio)
    {
        if ($precio < 0) {
            throw new Exception('El precio no puede ser negativo');
        }
        $this->precioVenta = (float)$precio;
    }

    public function setStockActual($stock)
    {
        if ($stock < 0) {
            throw new Exception('El stock no puede ser negativo');
        }
        $this->stockActual = (int)$stock;
    }

    public function setStockMinimo($stock)
    {
        if ($stock < 0) {
            throw new Exception('El stock mínimo no puede ser negativo');
        }
        $this->stockMinimo = (int)$stock;
    }

    public function setCategoriaId($id)
    {
        $this->categoriaId = $id === null ? null : (int)$id;
    }

    public function setTipo($tipo)
    {
        $tipos = ['estandar', 'fragil', 'perecedero'];
        if (!in_array($tipo, $tipos)) {
            throw new Exception('Tipo de producto inválido');
        }
        $this->tipo = $tipo;
    }

    public function stockCritico()
    {
        return $this->stockActual <= $this->stockMinimo;
    }

    public function descripcion()
    {
        return "Producto: {$this->nombre}";
    }

    public function guardar()
    {
        $sql = "INSERT INTO productos (nombre, sku, precio_venta, stock_actual, stock_minimo, categoria_id, tipo)
                VALUES (:nombre, :sku, :precio, :stock, :minimo, :categoria, :tipo)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nombre' => $this->nombre,
            ':sku' => $this->sku,
            ':precio' => $this->precioVenta,
            ':stock' => $this->stockActual,
            ':minimo' => $this->stockMinimo,
            ':categoria' => $this->categoriaId,
            ':tipo' => $this->tipo
        ]);
        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function actualizar()
    {
        $sql = "UPDATE productos SET nombre = :nombre, sku = :sku, precio_venta = :precio,
                stock_actual = :stock, stock_minimo = :minimo, categoria_id = :categoria, tipo = :tipo
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':sku' => $this->sku,
            ':precio' => $this->precioVenta,
            ':stock' => $this->stockActual,
            ':minimo' => $this->stockMinimo,
            ':categoria' => $this->categoriaId,
            ':tipo' => $this->tipo,
            ':id' => $this->id
        ]);
    }

    public function eliminar()
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
        return $stmt->execute([':id' => $this->id]);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fila) {
            return null;
        }
        return $this->mapear($fila);
    }

    public function listarTodos()
    {
        $stmt = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $productos = [];
        foreach ($filas as $fila) {
            $productos[] = $this->mapear($fila);
        }
        return $productos;
    }

    private function mapear($fila)
    {
        $tipo = $fila['tipo'];

        if ($tipo === 'fragil') {
            $p = new ProductoFragil();
        } elseif ($tipo === 'perecedero') {
            $p = new ProductoPerecedero();
        } else {
            $p = new ProductoEstandar();
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
