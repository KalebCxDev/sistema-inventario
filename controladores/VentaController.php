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

            foreach ($carrito as $item) {
                $producto = (new Producto())->buscarPorId($item['id']);
                if (!$producto) throw new Exception('Producto no encontrado');

                $cantidad = (int)$item['cantidad'];
                if ($cantidad <= 0) throw new Exception('Cantidad inválida');

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
            $venta->setCliente($_POST['cliente_nombre'] ?? '');
            $venta->setClienteId($_POST['cliente_id'] ?? null);
            $ventaId = $venta->guardar();

            $this->db->commit();
            header('Location: pos.php?ok=1&ticket_id=' . $ventaId);
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

    public function ticket()
    {
        $id = (int)($_GET['id'] ?? 0);
        $venta = (new Venta())->buscarPorId($id);

        if (!$venta) {
            header('Location: pos.php');
            exit;
        }

        $cliente = null;
        if (!empty($venta['cliente_id'])) {
            $stmt = conectar()->prepare("SELECT * FROM clientes WHERE id = :id");
            $stmt->execute([':id' => $venta['cliente_id']]);
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Parsear detalle para ítems del ticket
        $items = [];
        if (!empty($venta['detalle'])) {
            $partes = explode(', ', $venta['detalle']);
            foreach ($partes as $parte) {
                $pos = strrpos($parte, ' x');
                if ($pos !== false) {
                    $nombre = trim(substr($parte, 0, $pos));
                    $cant = (int)trim(substr($parte, $pos + 2));
                    
                    // Buscar precio de venta del producto si existe
                    $stmtProd = conectar()->prepare("SELECT precio_venta FROM productos WHERE nombre = :n LIMIT 1");
                    $stmtProd->execute([':n' => $nombre]);
                    $prod = $stmtProd->fetch(PDO::FETCH_ASSOC);
                    $precio = $prod ? (float)$prod['precio_venta'] : 0;

                    $items[] = [
                        'nombre' => $nombre,
                        'cantidad' => $cant,
                        'precio' => $precio,
                        'subtotal' => $precio * $cant
                    ];
                }
            }
        }

        require __DIR__ . '/../vistas/ver_ticket.php';
    }

    public function historial()
    {
        $ventas = (new Venta())->listarTodas();
        $error = null;
        require __DIR__ . '/../vistas/ventas_lista.php';
    }

    public function anular()
    {
        try {
            $id = (int)($_GET['id'] ?? 0);
            $ventaData = (new Venta())->buscarPorId($id);
            
            if (!$ventaData) throw new Exception('Venta no encontrada');
            if ($ventaData['estado'] === 'anulada') throw new Exception('Esta venta ya fue anulada');

            $this->db = conectar();
            $this->db->beginTransaction();

            $partes = explode(', ', $ventaData['detalle']);
            
            foreach ($partes as $parte) {
                $pedazos = explode(' x', $parte);
                $nombreProducto = trim($pedazos[0]);
                $cantidad = (int)$pedazos[1];

                $todosProductos = (new Producto())->listarTodos();
                $productoId = 0;
                foreach ($todosProductos as $p) {
                    if ($p->getNombre() === $nombreProducto) {
                        $productoId = $p->getId();
                        break;
                    }
                }

                if ($productoId > 0) {
                    $movimiento = new Movimiento();
                    $movimiento->setProductoId($productoId);
                    $movimiento->setTipo('entrada');
                    $movimiento->setCantidad($cantidad);
                    $movimiento->registrar();
                }
            }

            (new Venta())->anular($id);

            $this->db->commit();
            header('Location: ventas.php?anulada=1');
            exit;
        } catch (Exception $e) {
            if (isset($this->db) && $this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $ventas = (new Venta())->listarTodas();
            $error = $e->getMessage();
            require __DIR__ . '/../vistas/ventas_lista.php';
        }
    }
}