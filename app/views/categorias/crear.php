<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Categoría</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 400px; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 6px; margin-top: 4px; }
        button { margin-top: 15px; padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Nueva Categoría</h1>
    <a href="index.php?accion=categorias">← Volver</a>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?accion=categoria_guardar">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>