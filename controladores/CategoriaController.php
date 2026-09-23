<?php

class CategoriaController
{
    public function index()
    {
        $categorias = (new Categoria())->listarTodos();
        $error = null;
        require __DIR__ . '/../vistas/categorias_lista.php';
    }

    public function guardar()
    {
        try {
            $c = new Categoria();
            $c->setNombre($_POST['nombre'] ?? '');
            $c->guardar();
            header('Location: categorias.php');
            exit;
        } catch (Exception $e) {
            $categorias = (new Categoria())->listarTodos();
            $error = $e->getMessage();
            require __DIR__ . '/../vistas/categorias_lista.php';
        }
    }

    public function eliminar()
    {
        $c = (new Categoria())->buscarPorId($_GET['id'] ?? 0);
        if ($c) $c->eliminar();
        header('Location: categorias.php');
        exit;
    }
}