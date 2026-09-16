<?php

class AlertaController
{
    public function index()
    {
        $p = new Producto();
        $criticos = $p->listarCriticos();

        $todos = $p->listarTodos();
        $total = count($todos);
        $enAlerta = count($criticos);

        require __DIR__ . '/../views/alertas/index.php';
    }
}