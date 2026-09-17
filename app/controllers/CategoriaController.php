<?php

class CategoriaController
{
    public function index()
    {
        $categorias = (new Categoria())->listarTodos();
        require __DIR__ . '/../views/categorias/index.php';
    }

    public function crear()
    {
        $categorias = (new Categoria())->listarTodos();
        require __DIR__ . '/../views/categorias/index.php';
    }

    public function guardar()
    {
        try {
            $c = new Categoria();
            $c->setNombre($_POST['nombre'] ?? '');
            $c->guardar();
            $this->redirect();
        } catch (Exception $e) {
            $categorias = (new Categoria())->listarTodos();
            $error = $e->getMessage();
            require __DIR__ . '/../views/categorias/index.php';
        }
    }

    public function eliminar()
    {
        $c = (new Categoria())->buscarPorId($_GET['id'] ?? 0);
        if ($c) $c->eliminar();
        $this->redirect();
    }

    private function redirect()
    {
        header('Location: index.php?accion=categorias');
        exit;
    }
}