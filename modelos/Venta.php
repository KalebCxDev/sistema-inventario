<?php

class Venta
{
    private $id;
    private $total;
    private $detalle;
    private $cliente;
    private $clienteId;

    public function setId($v) { $this->id = (int)$v; }

    public function setTotal($v)
    {
        if ($v < 0) throw new Exception('El total no puede ser negativo');
        $this->total = (float)$v;
    }

    public function setDetalle($v)
    {
        if (trim($v) === '') throw new Exception('El detalle no puede estar vacío');
        $this->detalle = trim($v);
    }

    public function setCliente($v)
    {
        $this->cliente = (trim($v) === '') ? 'Varios' : trim($v);
    }

    public function setClienteId($v)
    {
        $this->clienteId = ($v === '' || $v === null) ? null : (int)$v;
    }

    public function getId() { return $this->id; }
    public function getTotal() { return $this->total; }
    public function getDetalle() { return $this->detalle; }
    public function getCliente() { return $this->cliente; }
    public function getClienteId() { return $this->clienteId; }

    public function guardar()
    {
        $dao = new VentaDAO(conectar());
        return $dao->guardar($this);
    }

    public function listarTodas()
    {
        $dao = new VentaDAO(conectar());
        return $dao->listarTodas();
    }

    public function buscarPorId($id)
    {
        $dao = new VentaDAO(conectar());
        return $dao->buscarPorId($id);
    }

    public function anular($id)
    {
        $dao = new VentaDAO(conectar());
        return $dao->anular($id);
    }
}
