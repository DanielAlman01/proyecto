<!--Contenido-->
<section id="featured" class="section">
    <h2>Anuncios Más Destacados</h2>
    
    <?php 
    $cards = $destacados;
    include("helpers/cards.php"); ?>

</section>

<section id="new" class="section">
    <h2>Nuenos Anuncios</h2>
    <div class="card-container">
        <?php foreach ($nuevos as $nue) { ?>

            <div class="card">
                <img src="https://via.placeholder.com/300" alt="<?= htmlspecialchars($nue->titulo) ?>">
                <h3><?= htmlspecialchars($nue->titulo) ?></h3>
                <p><b>Publicado por:</b> <?= htmlspecialchars($nue->nombre_usuario) ?></p>
                <p><b>Ubicación:</b> <?= htmlspecialchars($nue->ubicacion) ?></p>
                <p class="likes"><b>Likes:</b> <?= htmlspecialchars($nue->gusto) ?></p>
                <p> <a href="<?= BASE_URL ?>anuncio/verDetalles&id=<?= $nue->id_anuncio; ?>" class="btn btn-gris"> VER MAS DETALLES </a></p>
            </div>
        <?php } ?>
    </div>
</section>


<!--Fin de Contenido-->