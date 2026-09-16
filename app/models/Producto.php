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
}