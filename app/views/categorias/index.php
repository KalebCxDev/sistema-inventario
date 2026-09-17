<?php ob_start(); ?>
<h1>Categorías</h1>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="index.php?accion=categoria_guardar">
    <label>Nueva categoría:</label>
    <input type="text" name="nombre" required>
    <button type="submit">Agregar</button>
</form>

<table style="max-width:500px">
    <tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>
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
</table>
<?php $contenido = ob_get_clean(); require __DIR__ . '/../layout.php'; ?>