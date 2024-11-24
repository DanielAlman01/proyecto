<h2>Crear Nueva Categoria</h2>

<?php if (isset($_SESSION['registro']) && $_SESSION['registro'] === "Fallido") : ?>
    <strong class="alert_red">Registro fallido</strong>
<?php endif; ?>

<?php

$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$errores = isset($_SESSION['form_errores']) ? $_SESSION['form_errores'] : [];

?>

<?php utils::borrarSession('registro'); ?>


<section class="categoria-section">

    <form class="categoria-form" action="<?= BASE_URL ?>categoria/salvar" method="POST">

        <label for="nombre">Nombre Categoria</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($formData['nombre'] ?? '') ?>" required>
        <span class="error"><?= isset($errors['nombre']) ? $errors['nombre'] : '' ?></span>


        <button type="submit">Guardar</button>
    </form>

</section>