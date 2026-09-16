<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimientos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        form { max-width: 500px; margin-top: 15px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 6px; margin-top: 4px; }
        button { margin-top: 15px; padding: 8px 15px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .error { color: red; margin-top: 10px; }
        .entrada { color: green; font-weight: bold; }
        .salida { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Movimientos</h1>
    <a href="index.php?accion=index">← Productos</a>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <h2>Registrar movimiento</h2>
    <form method="POST" action="index.php?accion=movimiento_guardar">
        <label>Producto:</label>
        <select name="producto_id" required>
            <option value="">-- Seleccionar --</option>
            <?php foreach ($productos as $p): ?>
                <option value="<?= $p->getId() ?>">
                    <?= htmlspecialchars($p->getNombre()) ?> (stock: <?= $p->getStockActual() ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Tipo:</label>
        <select name="tipo" required>
            <option value="entrada">Entrada</option>
            <option value="salida">Salida</option>
        </select>

        <label>Cantidad:</label>
        <input type="number" name="cantidad" min="1" required>

        <button type="submit">Registrar</button>
    </form>

    <h2>Historial</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimientos as $m): ?>
                <tr>
                    <td><?= $m['id'] ?></td>
                    <td>
                        <?php
                            $encontrado = '-';
                            foreach ($productos as $p) {
                                if ($p->getId() == $m['producto_id']) {
                                    $encontrado = $p->getNombre();
                                    break;
                                }
                            }
                            echo htmlspecialchars($encontrado);
                        ?>
                    </td>
                    <td class="<?= $m['tipo'] ?>"><?= $m['tipo'] ?></td>
                    <td><?= $m['cantidad'] ?></td>
                    <td><?= $m['fecha'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>