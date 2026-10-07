<?php

class VentaController
{
    public function index()
    {
        $productos = (new Producto())->listarTodos();
        $error = null;
        require __DIR__ . '/../vistas/pos.php';
    }

    public function cobrar()
    {
        try {
            $carrito = json_decode($_POST['carrito'] ?? '[]', true);
            if (empty($carrito)) {
                throw new Exception('El carrito está vacío');
            }

            $this->db = conectar();
            $this->db->beginTransaction();

            $total = 0;
            $partes = [];
            $movimiento = new Movimiento();

            foreach ($carrito as $item) {
                $producto = (new Producto())->buscarPorId($item['id']);
                if (!$producto) {
                    throw new Exception('Producto no encontrado');
                }

                $cantidad = (int)$item['cantidad'];
                if ($cantidad <= 0) {
                    throw new Exception('Cantidad inválida');
                }

                $movimiento = new Movimiento();
                $movimiento->setProductoId($producto->getId());
                $movimiento->setTipo('salida');
                $movimiento->setCantidad($cantidad);
                $movimiento->registrar();

                $subtotal = $producto->getPrecioVenta() * $cantidad;
                $total += $subtotal;
                $partes[] = $producto->getNombre() . ' x' . $cantidad;
            }

            $venta = new Venta();
            $venta->setTotal($total);
            $venta->setDetalle(implode(', ', $partes));
            $venta->guardar();

            $this->db->commit();
            header('Location: pos.php?ok=1');
            exit;
        } catch (Exception $e) {
            if (isset($this->db) && $this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $productos = (new Producto())->listarTodos();
            $error = $e->getMessage();
            require __DIR__ . '/../vistas/pos.php';
        }
    }

    public function historial()
    {
        $ventas = (new Venta())->listarTodas();
        require __DIR__ . '/../vistas/ventas_lista.php';
    }
}