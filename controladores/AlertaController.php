<?php

class AlertaController
{
    public function index()
    {
        $criticos = (new Producto())->listarCriticos();
        $total = count((new Producto())->listarTodos());
        $enAlerta = count($criticos);
        require __DIR__ . '/../vistas/alertas_lista.php';
    }
}