<?php

class CategoriaController
{
    public function index()
    {
        $categoria = new Categoria();
        $categorias = $categoria->listarTodos();
        require __DIR__ . '/../views/categorias/index.php';
    }

    public function crear()
    {
        require __DIR__ . '/../views/categorias/crear.php';
    }

    public function guardar()
    {
        try {
            $c = new Categoria();
            $c->setNombre($_POST['nombre'] ?? '');
            $c->guardar();

            header('Location: index.php?accion=categorias');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../views/categorias/crear.php';
        }
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? 0;
        $c = new Categoria();
        $categoria = $c->buscarPorId($id);

        if ($categoria) {
            $categoria->eliminar();
        }

        header('Location: index.php?accion=categorias');
        exit;
    }
}