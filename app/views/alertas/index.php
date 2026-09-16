<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alertas de Stock</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .resumen { background: #fff3cd; border: 1px solid #ffc107; padding: 12px; border-radius: 4px; max-width: 400px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        .critico { background: #ffcccc; }
        .ok { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Alertas de Stock Crítico</h1>
    <a href="index.php?accion=index">← Productos</a> |
    <a href="index.php?accion=movimientos">Movimientos</a>

    <div class="resumen">
        <strong>Total de productos:</strong> <?= $total ?><br>
        <strong>Productos en alerta:</strong> <?= $enAlerta ?>
    </div>

    <?php if ($enAlerta === 0): ?>
        <p class="ok">✔ Todo en orden. No hay productos con stock crítico.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>SKU</th>
                    <th>Stock actual</th>
                    <th>Stock mínimo</th>
                    <th>Tipo</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($criticos as $p): ?>
                    <tr class="critico">
                        <td><?= $p->getId() ?></td>
                        <td><?= htmlspecialchars($p->getNombre()) ?></td>
                        <td><?= htmlspecialchars($p->getSku()) ?></td>
                        <td><?= $p->getStockActual() ?></td>
                        <td><?= $p->getStockMinimo() ?></td>
                        <td><?= $p->getTipo() ?></td>
                        <td><?= htmlspecialchars($p->detallesExtra()) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>