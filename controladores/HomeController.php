<?php

class HomeController
{
    public function index()
    {
        $totalProductos = count((new Producto())->listarTodos());
        $totalAlertas = count((new Producto())->listarCriticos());
        $totalCategorias = count((new Categoria())->listarTodos());
        $totalMovimientos = count((new Movimiento())->listarTodos());
        require __DIR__ . '/../vistas/home.php';
    }
}