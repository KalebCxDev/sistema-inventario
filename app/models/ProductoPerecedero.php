<?php

class ProductoPerecedero extends Producto
{
    private $diasVidaUtil = 30;

    public function getDiasVidaUtil() { return $this->diasVidaUtil; }
    public function setDiasVidaUtil($dias) { $this->diasVidaUtil = (int)$dias; }

    public function descripcion()
    {
        return "Perecedero: {$this->getNombre()} — consumir en {$this->diasVidaUtil} días";
    }

    public function stockCritico()
    {
        return $this->getStockActual() <= ($this->getStockMinimo() * 2);
    }
}