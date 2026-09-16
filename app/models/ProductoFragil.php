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

        public function detallesExtra()
    {
        return 'Recargo por manejo: S/ ' . number_format($this->recargoManejo(), 2);
    }
}