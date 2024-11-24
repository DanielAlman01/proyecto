<?php
if (isset($_SESSION['success'])) {
    echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']); // Limpiar el mensaje después de mostrarlo
}

if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']); // Limpiar el mensaje después de mostrarlo
}

$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$nombre = isset($formData['nombre']) ? $formData['nombre'] : '';
$email = isset($formData['email']) ? $formData['email'] : '';
$mensaje = isset($formData['mensaje']) ? $formData['mensaje'] : '';

unset($_SESSION['form_data']); // Limpiar los datos después de ser recuperados
?>

<section class="contact-section">
    <form class="contact-form" action="<?= BASE_URL ?>mensaje/mensajeAdmin" method="POST">
        <h2>Contáctanos</h2>
        <p>Si tienes alguna sugerencia o necesitas alguna información puedes escribirnos.</p>
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required value="<?= isset($_SESSION['form_data']['nombre']) ? htmlspecialchars($_SESSION['form_data']['nombre']) : '' ?>">

        <label for="email">Tu Correo Electrónico</label>
        <input type="email" id="email" name="email" required value="<?= isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : '' ?>">

        <label for="asunto">Asunto</label>
        <input type="text" id="asunto" name="asunto" required value="<?= isset($_SESSION['form_data']['asunto']) ? htmlspecialchars($_SESSION['form_data']['asunto']) : '' ?>">

        <label for="mensaje">Mensaje</label>
        <textarea id="mensaje" name="mensaje" required><?= isset($_SESSION['form_data']['mensaje']) ? htmlspecialchars($_SESSION['form_data']['mensaje']) : '' ?></textarea>

        <button type="submit">Enviar Mensaje</button>

        <a href="<?= BASE_URL ?>anuncio/index" class="btn btn-gris">CANCELAR</a>
    </form>
</section>