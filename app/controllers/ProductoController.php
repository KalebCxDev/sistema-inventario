<?php

class ProductoController
{
    public function index()
    {
        $producto = new Producto();
        $productos = $producto->listarTodos();
        require __DIR__ . '/../views/productos/index.php';
    }

    public function crear()
    {
        require __DIR__ . '/../views/productos/crear.php';
    }

    public function guardar()
    {
        try {
            $p = new Producto();
            $p->setNombre($_POST['nombre'] ?? '');
            $p->setSku($_POST['sku'] ?? '');
            $p->setPrecioVenta($_POST['precio_venta'] ?? 0);
            $p->setStockActual($_POST['stock_actual'] ?? 0);
            $p->setStockMinimo($_POST['stock_minimo'] ?? 0);
            $p->setTipo($_POST['tipo'] ?? 'estandar');
            $p->guardar();

            header('Location: index.php?accion=index');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../views/productos/crear.php';
        }
    }

    public function editar()
    {
        $id = $_GET['id'] ?? 0;
        $p = new Producto();
        $producto = $p->buscarPorId($id);

        if (!$producto) {
            header('Location: index.php?accion=index');
            exit;
        }

        require __DIR__ . '/../views/productos/editar.php';
    }

    public function actualizar()
    {
        try {
            $p = new Producto();
            $p->setId($_POST['id'] ?? 0);
            $p->setNombre($_POST['nombre'] ?? '');
            $p->setSku($_POST['sku'] ?? '');
            $p->setPrecioVenta($_POST['precio_venta'] ?? 0);
            $p->setStockActual($_POST['stock_actual'] ?? 0);
            $p->setStockMinimo($_POST['stock_minimo'] ?? 0);
            $p->setTipo($_POST['tipo'] ?? 'estandar');
            $p->actualizar();

            header('Location: index.php?accion=index');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $p = new Producto();
            $producto = $p->buscarPorId($_POST['id'] ?? 0);
            require __DIR__ . '/../views/productos/editar.php';
        }
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? 0;
        $p = new Producto();
        $producto = $p->buscarPorId($id);

        if ($producto) {
            $producto->eliminar();
        }

        header('Location: index.php?accion=index');
        exit;
    }
}