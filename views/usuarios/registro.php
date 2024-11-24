<h2>Registro de Usuario</h2>

<?php if (isset($_SESSION['registro']) && $_SESSION['registro'] === "Completo") : ?>
    <strong class="alert_green">Registro completado correctamente</strong>
<?php elseif (isset($_SESSION['registro']) && $_SESSION['registro'] === "Fallido") : ?>
    <strong class="alert_red">Registro fallido: <?= $_SESSION['error_mensaje'] ?></strong>
<?php endif; ?>

<?php utils::borrarSession('registro'); ?>
<?php utils::borrarSession('error_mensaje'); ?>

<section class="registration-section">
    <form class="registration-form" action="<?= BASE_URL ?>usuario/salvar" method="POST">

        <label for="username">Nombre de Usuario</label>
        <input type="text" id="username" name="username" value="<?= isset($_SESSION['form_data']['username']) ? htmlspecialchars($_SESSION['form_data']['username']) : '' ?>" required>

        <label for="lastname">Apellido de Usuario</label>
        <input type="text" id="lastname" name="lastname" value="<?= isset($_SESSION['form_data']['lastname']) ? htmlspecialchars($_SESSION['form_data']['lastname']) : '' ?>" required>

        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" value="<?= isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : '' ?>" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirmar Contraseña</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Registrarse</button>
    </form>
</section>