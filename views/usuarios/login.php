<h2>Iniciar Sesión</h2>

<?php if (isset($_SESSION['error_login']) && $_SESSION['error_login'] === 'Identificación fallida...') : ?>

    <strong class="alert_red">Inicio de Sesión Fallido...</strong>

<?php endif; ?>

<?php utils::borrarSession('error_login'); ?>

<section class="login-section">
    <form class="login-form" action="<?= BASE_URL ?>usuario/identificarse" method="POST">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Ingresar</button>
    </form>
</section>