<?php 
require __DIR__ . '/header.php'; 
$esNuevo = $usuario === null;
$accionForm = $esNuevo ? 'usuario_guardar.php' : 'usuario_actualizar.php';
?>

<h1><?= $esNuevo ? 'Nuevo Usuario' : 'Editar Usuario' ?></h1>
<a href="usuarios.php">← Volver a la lista</a>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="<?= $accionForm ?>">
    <?php if (!$esNuevo): ?>
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
    <?php endif; ?>

    <label>Nombre completo:</label>
    <input type="text" name="nombre" value="<?= $esNuevo ? '' : htmlspecialchars($usuario['nombre']) ?>" required>

    <label>Nombre de usuario (para iniciar sesión):</label>
    <input type="text" name="usuario" value="<?= $esNuevo ? '' : htmlspecialchars($usuario['usuario']) ?>" required>

    <label>Contraseña:</label>
    <input type="password" name="password" <?= $esNuevo ? 'required' : '' ?> placeholder="<?= $esNuevo ? '' : 'Dejar en blanco para mantener la actual' ?>">

    <label>Rol:</label>
    <select name="rol" required>
        <option value="admin" <?= (!$esNuevo && $usuario['rol'] === 'admin') ? 'selected' : '' ?>>Administrador</option>
        <option value="vendedor" <?= (!$esNuevo && $usuario['rol'] === 'vendedor') ? 'selected' : '' ?>>Vendedor</option>
        <option value="recepcionista" <?= (!$esNuevo && $usuario['rol'] === 'recepcionista') ? 'selected' : '' ?>>Recepcionista / Almacén</option>
    </select>

    <button type="submit"><?= $esNuevo ? 'Guardar' : 'Actualizar' ?></button>
</form>

<?php require __DIR__ . '/footer.php'; ?>