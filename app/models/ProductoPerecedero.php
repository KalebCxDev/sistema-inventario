<?php

class ProductoPerecedero extends Producto
{
    private $diasVidaUtil = 30;

    public function getDiasVidaUtil() { return $this->diasVidaUtil; }
    public function setDiasVidaUtil($d) { $this->diasVidaUtil = (int)$d; }

    public function descripcion() { return "Perecedero: {$this->getNombre()} — consumir en {$this->diasVidaUtil} días"; }
    public function detallesExtra() { return 'Vida útil: ' . $this->diasVidaUtil . ' días'; }
    public function stockCritico() { return $this->getStockActual() <= ($this->getStockMinimo() * 2); }
}