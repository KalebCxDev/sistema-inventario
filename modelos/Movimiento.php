<?php

class Movimiento
{
    private $id;
    private $productoId;
    private $tipo;
    private $cantidad;

    public function getId() { return $this->id; }
    public function getProductoId() { return $this->productoId; }
    public function getTipo() { return $this->tipo; }
    public function getCantidad() { return $this->cantidad; }

    public function setId($v) { $this->id = (int)$v; }

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
        $dao = new MovimientoDAO(conectar());
        return $dao->registrar($this);
    }

    public function listarTodos()
    {
        $dao = new MovimientoDAO(conectar());
        return $dao->listarTodos();
    }
}
