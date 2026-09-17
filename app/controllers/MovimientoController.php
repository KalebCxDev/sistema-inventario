<?php

class MovimientoController
{
    public function index()
    {
        $this->render();
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
            $this->render($e->getMessage());
        }
    }

    private function render($error = null)
    {
        $movimientos = (new Movimiento())->listarTodos();
        $productos = (new Producto())->listarTodos();
        require __DIR__ . '/../views/movimientos/index.php';
    }
}