<a href="<?= BASE_URL ?>categoria/crear" class="btn btn-azul">CREAR CATEGORIAS</a>

<h2>Gestionar Categorias</h2>

<?php if (isset($_SESSION['registro']) && $_SESSION['registro'] === "Completo") : ?>
    <strong class="alert_green">Categoria creada correctamente</strong>
<?php endif; ?>

<?php utils::borrarSession('registro'); ?>

<table class="tabla_info">

    <?php if ($categorias == false) : ?>
        <tr>
            <th>ID</th>
            <th>CATEGORIA</th>
        </tr>
        <tr>
            <td colspan="2">Noy hay categorias registradas</td>
        </tr>
    <?php else : ?>

        <tr>
            <th>ID</th>
            <th>CATEGORIA</th>
        </tr>
        <?php foreach ($categorias as $cat) : ?>
            <tr>
                <td><?= $cat->id_categoria; ?></td>
                <td><?= $cat->nombre_categoria; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>