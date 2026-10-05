<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1 { font-size: 18px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background: #eee; }
        .critico { background: #ffcccc; }
    </style>
</head>
<body>
    <h1>Reporte de Productos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>SKU</th><th>Precio</th>
                <th>Stock</th><th>Mínimo</th><th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
                <tr class="<?= $p->stockCritico() ? 'critico' : '' ?>">
                    <td><?= $p->getId() ?></td>
                    <td><?= htmlspecialchars($p->getNombre()) ?></td>
                    <td><?= htmlspecialchars($p->getSku()) ?></td>
                    <td><?= number_format($p->getPrecioVenta(), 2) ?></td>
                    <td><?= $p->getStockActual() ?></td>
                    <td><?= $p->getStockMinimo() ?></td>
                    <td><?= $p->getTipo() ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>