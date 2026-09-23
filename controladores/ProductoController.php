<?php

class ProductoController
{
    public function index()
    {
        $productos = (new Producto())->listarTodos();
        $enAlerta = count((new Producto())->listarCriticos());
        require __DIR__ . '/../vistas/productos_lista.php';
    }

    public function crear()
    {
        $producto = null;
        $categorias = (new Categoria())->listarTodos();
        $error = null;
        require __DIR__ . '/../vistas/productos_form.php';
    }

    public function editar()
    {
        $producto = (new Producto())->buscarPorId($_GET['id'] ?? 0);
        if (!$producto) {
            header('Location: productos.php');
            exit;
        }
        $categorias = (new Categoria())->listarTodos();
        $error = null;
        require __DIR__ . '/../vistas/productos_form.php';
    }

    public function guardar()
    {
        try {
            $p = new Producto();
            $p->llenar($_POST);
            $p->guardar();
            header('Location: productos.php');
            exit;
        } catch (Exception $e) {
            $producto = null;
            $categorias = (new Categoria())->listarTodos();
            $error = $e->getMessage();
            require __DIR__ . '/../vistas/productos_form.php';
        }
    }

    public function actualizar()
    {
        try {
            $p = new Producto();
            $p->llenar($_POST);
            $p->setId($_POST['id'] ?? 0);
            $p->actualizar();
            header('Location: productos.php');
            exit;
        } catch (Exception $e) {
            $producto = null;
            $categorias = (new Categoria())->listarTodos();
            $error = $e->getMessage();
            require __DIR__ . '/../vistas/productos_form.php';
        }
    }

    public function eliminar()
    {
        $producto = (new Producto())->buscarPorId($_GET['id'] ?? 0);
        if ($producto) $producto->eliminar();
        header('Location: productos.php');
        exit;
    }
}