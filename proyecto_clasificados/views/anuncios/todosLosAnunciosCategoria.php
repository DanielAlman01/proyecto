<section id="featured" class="section">

    <h2>
        <?php if (isset($anuncios[1]->id_anuncio)) { ?>
            Anuncios de <?= htmlspecialchars($anuncios[0]->nombre_categoria) ?>


        <?php } else { ?>
            Categoria <?= htmlspecialchars($anuncios[0]->nombre_categoria ?? 'desconocida') ?>

        <?php } ?>
    </h2>

    <br>
    <div class="card-container">
        <?php foreach ($anuncios as $anuncio) { ?>
            <?php if (isset($anuncio->id_anuncio)) { ?>

                <div class="card">
                
                
                <?php if ($anuncio->ruta_imagen) { ?>
                    <img src="<?= BASE_URL . $anuncio->ruta_imagen ?>" alt="<?= htmlspecialchars($anuncio->titulo) ?>">
            <?php } else { ?>

                <img src="https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg?w=300">

            <?php }  ?>
                
               
                   
                   
                    <h3><?= htmlspecialchars($anuncio->titulo) ?></h3>
                    <p>Publicado por: <?= htmlspecialchars($anuncio->nombre_usuario) ?></p>
                    <p>Ubicación: <?= htmlspecialchars($anuncio->ubicacion) ?></p>
                    <p class="likes">Likes: <?= htmlspecialchars($anuncio->gusto) ?></p>
                    <p> <a href="<?= BASE_URL ?>anuncio/verDetalles&id=<?= $anuncio->id_anuncio; ?>" class="btn btn-gris"> VER MAS DETALLES </a></p>

                </div>


            <?php } else { ?>
                <div class="card">
                    <p>En estos momentos no se han publicado anuncios o clasificados para esta categoría.</p>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</section>





<!--Fin de Contenido-->