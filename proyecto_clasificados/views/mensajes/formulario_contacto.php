<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
</head>
<body>
    <h1>Enviar Mensaje</h1>
    <?php if (isset($_SESSION['success'])): ?>
        <p style="color: green;"><?= $_SESSION['success'] ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="MensajeController.php?action=guardar" method="POST">
        <label for="remitente">Tu Correo Electrónico:</label><br>
        <input type="email" id="remitente" name="remitente" required><br><br>

        <label for="contenido">Mensaje:</label><br>
        <textarea id="contenido" name="contenido" required></textarea><br><br>

        <button type="submit">Enviar Mensaje</button>
    </form>
</body>
</html>

