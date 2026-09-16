<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        .btn { padding: 6px 12px; text-decoration: none; color: white; border-radius: 3px; }
        .nuevo { background: #28a745; }
        .editar { background: #007bff; }
        .eliminar { background: #dc3545; }
        .critico { background: #ffcccc; }
    </style>
</head>
<body>
    <h1>Listado de Productos</h1>
    <a href="index.php?accion=crear" class="btn nuevo">+ Nuevo Producto</a>

    <table>
        <thead>
            <tr>
                <th>Categoría</th>
                <th>ID</th>
                <th>Nombre</th>
                <th>SKU</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Mínimo</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
                <tr class="<?= $p->stockCritico() ? 'critico' : '' ?>">
                    <td>
                        <?php
                            if ($p->getCategoriaId()) {
                                $cat = new Categoria();
                                $c = $cat->buscarPorId($p->getCategoriaId());
                                echo $c ? htmlspecialchars($c->getNombre()) : '-';
                            } else {
                                echo '-';
                            }
                        ?>
                    </td>
                    <td><?= $p->getId() ?></td>
                    <td><?= htmlspecialchars($p->getNombre()) ?></td>
                    <td><?= htmlspecialchars($p->getSku()) ?></td>
                    <td>$<?= number_format($p->getPrecioVenta(), 2) ?></td>
                    <td><?= $p->getStockActual() ?></td>
                    <td><?= $p->getStockMinimo() ?></td>
                    <td><?= ucfirst(htmlspecialchars($p->getTipo())) ?></td>
                    <td><?= htmlspecialchars($p->descripcion()) ?></td>
                    <td>
                        <a href="index.php?accion=editar&id=<?= $p->getId() ?>" class="btn editar">Editar</a>
                        <a href="index.php?accion=eliminar&id=<?= $p->getId() ?>" class="btn eliminar"
                           onclick="return confirm('¿Eliminar producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
