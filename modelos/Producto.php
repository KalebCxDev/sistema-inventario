<?php

class Producto
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
        $dao = new ProductoDAO(conectar());
        return $dao->guardar($this);
    }

    public function actualizar()
    {
        $dao = new ProductoDAO(conectar());
        return $dao->actualizar($this);
    }

    public function eliminar()
    {
        $dao = new ProductoDAO(conectar());
        return $dao->eliminar($this->id);
    }

    public function buscarPorId($id)
    {
        $dao = new ProductoDAO(conectar());
        return $dao->buscarPorId($id);
    }

    public function listarTodos()
    {
        $dao = new ProductoDAO(conectar());
        return $dao->listarTodos();
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
}
