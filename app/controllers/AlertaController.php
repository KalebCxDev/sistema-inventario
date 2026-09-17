<?php

class AlertaController
{
    public function index()
    {
        $p = new Producto();
        $criticos = $p->listarCriticos();
        $total = count($p->listarTodos());
        $enAlerta = count($criticos);
        require __DIR__ . '/../views/alertas/index.php';
    }
}