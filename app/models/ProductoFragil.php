<?php

class ProductoFragil extends Producto
{
    public function descripcion()
    {
        return "⚠ FRÁGIL: {$this->getNombre()} — manipular con cuidado";
    }

    public function recargoManejo()
    {
        return round($this->getPrecioVenta() * 0.05, 2);
    }
}