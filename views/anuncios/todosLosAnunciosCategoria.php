<section id="featured" class="section">
<div class="card-container">
    <h2>
        <?php if (isset($anuncios[1]->id_anuncio)) { ?>
            Anuncios de <?= htmlspecialchars($anuncios[0]->nombre_categoria) ?>




        <?php } else { ?>
            Categoria <?= htmlspecialchars($anuncios[0]->nombre_categoria ?? 'desconocida') ?>
        <?php } ?>
    </h2>

    
        <?php foreach ($anuncios as $anuncio) { ?>
            <?php if (isset($anuncio->id_anuncio))  { ?>
            
                <div class="card">
                    <img src="<?= BASE_URL . $anuncio->ruta_imagen ?>" alt="<?= htmlspecialchars($anuncio->titulo) ?>">
                    <h3><?= htmlspecialchars($anuncio->titulo) ?></h3>
                    <p>Publicado por: <?= htmlspecialchars($anuncio->nombre_usuario) ?></p>
                    <p>Ubicación: <?= htmlspecialchars($anuncio->ubicacion) ?></p>
                    <p class="likes">Likes: <?= htmlspecialchars($anuncio->gusto) ?></p>
                    <p> <a href="<?= BASE_URL ?>anuncio/verDetalles&id=<?= $anuncio->id_anuncio; ?>" class="btn btn-gris"> VER MAS DETALLES </a></p>
                
                </div>
          
      
    <?php } else { ?>
        <p>En estos momentos no se han publicado anuncios o clasificados para esta categoría.</p>
    <?php } ?>
    <?php } ?>
    </div>
</section>





<!--Fin de Contenido-->