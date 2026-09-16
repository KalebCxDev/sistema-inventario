<?php

class MovimientoController
{
    public function index()
    {
        $m = new Movimiento();
        $movimientos = $m->listarTodos();

        $p = new Producto();
        $productos = $p->listarTodos();

        require __DIR__ . '/../views/movimientos/index.php';
    }

    public function guardar()
    {
        try {
            $m = new Movimiento();
            $m->setProductoId($_POST['producto_id'] ?? 0);
            $m->setTipo($_POST['tipo'] ?? '');
            $m->setCantidad($_POST['cantidad'] ?? 0);
            $m->registrar();

            header('Location: index.php?accion=movimientos');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();

            $m = new Movimiento();
            $movimientos = $m->listarTodos();

            $p = new Producto();
            $productos = $p->listarTodos();

            require __DIR__ . '/../views/movimientos/index.php';
        }
    }
}