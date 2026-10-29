<?php require __DIR__ . '/header.php'; ?>

<h1>Gestión de Usuarios</h1>

<?php if (isset($_GET['error']) && $_GET['error'] === 'self'): ?>
    <p class="error">No puedes eliminar tu propia cuenta mientras estás logueado.</p>
<?php endif; ?>

<a href="usuarios.php?accion=crear" class="btn nuevo">+ Nuevo Usuario</a>

<div class="table-responsive" style="max-width: 800px; margin-top: 18px;">
    <table>
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><strong>#<?= $u['id'] ?></strong></td>
                    <td style="font-weight: 500;"><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><code><?= htmlspecialchars($u['usuario']) ?></code></td>
                    <td>
                        <span class="badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">
                            <?= ucfirst($u['rol']) ?>
                        </span>
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="usuarios.php?accion=editar&id=<?= $u['id'] ?>" class="btn editar">Editar</a>
                        <?php if ($u['id'] != $_SESSION['usuario_id']): ?>
                            <a href="usuarios.php?accion=eliminar&id=<?= $u['id'] ?>" class="btn eliminar"
                               onclick="return confirm('¿Seguro que deseas eliminar al usuario &quot;<?= htmlspecialchars($u['usuario'], ENT_QUOTES) ?>&quot;?')">Eliminar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/footer.php'; ?>
