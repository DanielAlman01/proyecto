<div class="card-container">
        <?php foreach ($cards as $card) { ?>

            <div class="card crad-contend_prin">
                <?php if ($card->ruta_imagen) { ?>
                    <img src="<?= BASE_URL . $card->ruta_imagen ?>" alt="<?= htmlspecialchars($card->titulo) ?>">
                <?php } else { ?>

                    <img src="https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg?w=300">

                <?php }  ?>
                <h3><?= htmlspecialchars($card->titulo) ?></h3>
                <div>
                    <p><b>Publicado por:</b> <?= htmlspecialchars($card->nombre_usuario) ?></p>
                    <p><b>Ubicación:</b> <?= htmlspecialchars($card->ubicacion) ?></p>
                </div>

                <div class="btn-like">
                    <p> <a href="<?= BASE_URL ?>anuncio/verDetalles&id=<?= $card->id_anuncio; ?>" class="btn btn-gris"> ver mas </a></p>
                    <p class="likes"><b>Likes:</b> <?= htmlspecialchars($card->gusto) ?></p>
                </div>
                
            </div>
        <?php } ?>
    </div>