<?php

class MovimientoController
{
    public function index()
    {
        $movimientos = (new Movimiento())->listarTodos();
        $productos = (new Producto())->listarTodos();
        $error = null;
        $productoSeleccionado = isset($_GET['producto_id']) ? (int)$_GET['producto_id'] : 0;
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
            $productoSeleccionado = (int)($_POST['producto_id'] ?? 0);
            require __DIR__ . '/../vistas/movimientos_lista.php';
        }
    }
}