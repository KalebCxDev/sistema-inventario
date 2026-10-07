<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <div class="login-caja">
        <h1>Iniciar sesión</h1>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php?accion=autenticar">
            <label>Usuario:</label>
            <input type="text" name="usuario" required autofocus>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>