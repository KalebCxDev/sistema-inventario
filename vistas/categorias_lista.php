<?php require __DIR__ . '/header.php'; ?>

<h1>Categorías</h1>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if (in_array(rolActual(), ['admin', 'recepcionista'])): ?>
    <form method="POST" action="categorias.php?accion=guardar" style="margin-bottom: 24px;">
        <label for="input-nombre-cat">Nueva categoría:</label>
        <div style="display: flex; gap: 10px; align-items: center;">
            <input type="text" id="input-nombre-cat" name="nombre" placeholder="Nombre de categoría..." required style="margin: 0; flex: 1;">
            <button type="submit" class="azul" style="margin: 0;">Agregar</button>
        </div>
    </form>
<?php endif; ?>

<div class="table-responsive" style="max-width: 600px;">
    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $c): ?>
                <tr>
                    <td><strong>#<?= $c->getId() ?></strong></td>
                    <td style="font-weight: 500;"><?= htmlspecialchars($c->getNombre()) ?></td>
                    <td>
                        <?php if (rolActual() === 'admin'): ?>
                            <a href="categorias.php?accion=eliminar&id=<?= $c->getId() ?>" class="btn eliminar"
                               onclick="return confirm('¿Seguro que deseas eliminar la categoría &quot;<?= htmlspecialchars($c->getNombre(), ENT_QUOTES) ?>&quot;?')">Eliminar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/footer.php'; ?>
