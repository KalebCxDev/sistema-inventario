<?php

class MovimientoController
{
    public function index()
    {
        $movimientos = (new Movimiento())->listarTodos();
        $productos = (new Producto())->listarTodos();
        $error = null;
        require __DIR__ . '/../vistas/movimientos_lista.php';
    }

    public function guardar()
    {
        try {
            $m = new Movimiento();
            $m->setProductoId($_POST['producto_id'] ?? 0);
            $m->setTipo($_POST['tipo'] ?? '');
            $m->setCantidad($_POST['cantidad'] ?? 0);
            $m->registrar();
            header('Location: movimientos.php');
            exit;
        } catch (Exception $e) {
            $movimientos = (new Movimiento())->listarTodos();
            $productos = (new Producto())->listarTodos();
            $error = $e->getMessage();
            require __DIR__ . '/../vistas/movimientos_lista.php';
        }
    }
}