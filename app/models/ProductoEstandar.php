<?php

class ProductoEstandar extends Producto
{
    public function descripcion() { return "Producto estándar: {$this->getNombre()} (SKU: {$this->getSku()})"; }
    public function detallesExtra() { return 'Sin características especiales'; }
}