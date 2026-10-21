<?php require __DIR__ . '/header.php'; ?>

<h1>Gestión de Usuarios</h1>

<?php if (isset($_GET['error']) && $_GET['error'] === 'self'): ?>
    <p class="error">No puedes eliminar tu propia cuenta mientras estás logueado.</p>
<?php endif; ?>

<a href="usuario_crear.php" class="btn nuevo">+ Nuevo Usuario</a>

<table style="max-width:700px">
    <tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Acciones</th></tr>
    <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['nombre']) ?></td>
            <td><?= htmlspecialchars($u['usuario']) ?></td>
            <td><?= ucfirst($u['rol']) ?></td>
            <td>
                <a href="usuario_editar.php?id=<?= $u['id'] ?>" class="btn editar">Editar</a>
                <?php if ($u['id'] != $_SESSION['usuario_id']): ?>
                    <a href="usuario_eliminar.php?id=<?= $u['id'] ?>" class="btn eliminar"
                       onclick="return confirm('¿Eliminar usuario?')">Eliminar</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . '/footer.php'; ?>