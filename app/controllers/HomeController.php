<?php

class HomeController
{
    public function index()
    {
        $p = new Producto();
        $totalProductos = count($p->listarTodos());
        $totalAlertas = count($p->listarCriticos());
        $totalCategorias = count((new Categoria())->listarTodos());
        $totalMovimientos = count((new Movimiento())->listarTodos());
        require __DIR__ . '/../views/home.php';
    }
}
