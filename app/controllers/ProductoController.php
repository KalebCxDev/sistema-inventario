<?php

class ProductoController
{
    public function index()
    {
        $p = new Producto();
        $this->render('productos/index', [
            'productos' => $p->listarTodos(),
            'enAlerta' => count($p->listarCriticos()),
        ]);
    }

    public function crear()
    {
        $this->render('productos/formulario', [
            'producto' => null,
            'categorias' => (new Categoria())->listarTodos(),
        ]);
    }

    public function editar()
    {
        $producto = (new Producto())->buscarPorId($_GET['id'] ?? 0);
        if (!$producto) return $this->redirect('index');

        $this->render('productos/formulario', [
            'producto' => $producto,
            'categorias' => (new Categoria())->listarTodos(),
        ]);
    }

    public function guardar()
    {
        $this->procesar(fn($p) => $p->guardar());
    }

    public function actualizar()
    {
        $this->procesar(function ($p) {
            $p->setId($_POST['id'] ?? 0);
            $p->actualizar();
        });
    }

    public function eliminar()
    {
        $producto = (new Producto())->buscarPorId($_GET['id'] ?? 0);
        if ($producto) $producto->eliminar();
        $this->redirect('index');
    }

    private function procesar($accion)
    {
        try {
            $p = new Producto();
            $p->llenar($_POST);
            $accion($p);
            $this->redirect('index');
        } catch (Exception $e) {
            $this->render('productos/formulario', [
                'producto' => null,
                'categorias' => (new Categoria())->listarTodos(),
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function render($vista, $datos = [])
    {
        extract($datos);
        require __DIR__ . '/../views/' . $vista . '.php';
    }

    private function redirect($accion)
    {
        header("Location: index.php?accion=$accion");
        exit;
    }
}