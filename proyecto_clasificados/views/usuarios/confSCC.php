<h2>Iniciar Sesión</h2>

<?php if (isset($_SESSION['error_login']) && $_SESSION['error_login'] === 'Identificación fallida...') : ?>

    <strong class="alert_red">Inicio de Sesión Fallido...</strong>

<?php endif; ?>

<section>
    <div class="card-container">
        <p class="card">

            Si has olvidado tu clave haremos lo siguiente: Presionaras el boton a continuacion y
            llegara a tu correo una clave temporal con la cual podras entrar al sitio de Clasificados y luego deberas cambiar
            estas clave temporal por tu nueva clave.
        </p>

        <form class="login-form" action="<?= BASE_URL ?>usuario/clavTemp" method="POST">

            <label for="email">Ingresa el Email que registraste</label>
            <input type="email" id="email" name="email" required>


            <button type="submit">Ingresar</button>


        </form>

    </div>


</section>
