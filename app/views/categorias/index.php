<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; max-width: 500px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        .btn { padding: 6px 12px; text-decoration: none; color: white; border-radius: 3px; }
        .nuevo { background: #28a745; }
        .eliminar { background: #dc3545; }
    </style>
</head>
<body>
    <?php if ($enAlerta > 0): ?>
        <div style="background:#fff3cd;border:1px solid #ffc107;padding:10px;border-radius:4px;margin-bottom:10px;">
            ⚠ Hay <strong><?= $enAlerta ?></strong> producto(s) con stock crítico.
            <a href="index.php?accion=alertas">Ver alertas</a>
        </div>
    <?php endif; ?>
    <h1>Categorías</h1>
    <a href="index.php?accion=index">← Productos</a> |
    <a href="index.php?accion=categoria_crear" class="btn nuevo">+ Nueva Categoría</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $c): ?>
                <tr>
                    <td><?= $c->getId() ?></td>
                    <td><?= htmlspecialchars($c->getNombre()) ?></td>
                    <td>
                        <a href="index.php?accion=categoria_eliminar&id=<?= $c->getId() ?>" class="btn eliminar"
                           onclick="return confirm('¿Eliminar categoría?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>