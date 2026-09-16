<?php

require_once __DIR__ . '/../core/autoload.php';

$p = new Producto();
$p->setNombre('Laptop ');
$p->setSku('lap-001');
$p->setPrecioVenta(1500.50);
$p->setStockActual(5);
$p->setStockMinimo(10);
$p->setTipo('estandar');

echo "<h1>Prueba de Producto</h1>";
echo "Nombre: " . $p->getNombre() . "<br>";
echo "SKU: " . $p->getSku() . "<br>";
echo "Precio: " . $p->getPrecioVenta() . "<br>";
echo "Stock actual: " . $p->getStockActual() . "<br>";
echo "Stock mínimo: " . $p->getStockMinimo() . "<br>";
echo "¿Stock crítico?: " . ($p->stockCritico() ? 'Sí' : 'No') . "<br>";