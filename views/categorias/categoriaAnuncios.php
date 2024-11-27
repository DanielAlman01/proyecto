<section class="secction-getion-anuncio">
    <h2>Ver Anuncios por Categoria</h2>



    <table class="tabla_info">

        <?php if ($categorias == false) : ?>
            <tr>
                <th>ID</th>
                <th>CATEGORIA</th>
                <th>VER ANUNCIOS</th>
            </tr>
            <tr>
                <td colspan="2">Noy hay categorias registradas</td>
            </tr>
        <?php else : ?>

            <tr>
                <th>ID</th>
                <th>CATEGORIA</th>
                <th>VER ANUNCIOS</th>
            </tr>
            <?php foreach ($categorias as $cat) : ?>
                <tr>
                    <td><?= $cat->id_categoria; ?></td>
                    <td><?= $cat->nombre_categoria; ?></td>
                    <td><a href="<?= BASE_URL ?>anuncio/mostrarAnunciosXCategoria&id=<?= $cat->id_categoria; ?>"  class="btn btn-gris">VER ANUNCIOS...</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</section>