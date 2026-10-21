<?php require __DIR__ . '/header.php'; ?>

<h1>Categorías</h1>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if (in_array(rolActual(), ['admin', 'recepcionista'])): ?>
    <form method="POST" action="categoria_guardar.php">
        <label>Nueva categoría:</label>
        <input type="text" name="nombre" required>
        <button type="submit">Agregar</button>
    </form>
<?php endif; ?>

<table style="max-width:500px">
    <tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>
    <?php foreach ($categorias as $c): ?>
        <tr>
            <td><?= $c->getId() ?></td>
            <td><?= htmlspecialchars($c->getNombre()) ?></td>
            <td>
                <?php if (rolActual() === 'admin'): ?>
                    <a href="categoria_eliminar.php?id=<?= $c->getId() ?>" class="btn eliminar"
                       onclick="return confirm('¿Eliminar categoría?')">Eliminar</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . '/footer.php'; ?>