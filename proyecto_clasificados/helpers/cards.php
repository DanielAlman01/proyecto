<div class="card-container">


    <?php 
    $ident = utils::isSession();
    
    foreach ($cards as $card) { ?>

        <div class="card">
            <?php if ($card->ruta_imagen) { ?>
                <img src="<?= BASE_URL . $card->ruta_imagen ?>" alt="<?= htmlspecialchars($card->titulo) ?>">
            <?php } else { ?>

                <img src="https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg?w=300">

            <?php }  ?>
            <h3><?= htmlspecialchars($card->titulo) ?></h3>
            <p><b>Publicado por:</b> <?= htmlspecialchars($card->nombre_usuario) ?></p>
            <p><b>Ubicación:</b> <?= htmlspecialchars($card->ubicacion) ?></p>

            <?php if ($ident != null)  { ?>

            <p class="likes">
            <form id="likeForm" method="POST" action="<?= BASE_URL ?>likes/agregar">
                <input type="hidden" name="id_anuncio" value="1">
                <button type="submit" class="like-button" disabled>👍 Like</button>
            </form>
            <div id="likeCount">Likes: <?= htmlspecialchars($card->gusto) ?> </div>
            </p>
            <?php }?>

            <script>
                document.getElementById('likeForm').addEventListener('submit', function(e) {
                    e.preventDefault(); // Evitar el envío por defecto

                    fetch('<?= BASE_URL ?>likes/agregar', {
                            method: 'POST',
                            body: new FormData(this)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('likeCount').innerText = `Likes: ${data.total_likes}`;
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => console.error('Error en la solicitud:', error));
                });
            </script>

            <?php  if ($ident != null) { ?>
                <p> <a href="<?= BASE_URL ?>anuncio/verDetalles&id=<?= $card->id_anuncio; ?>" class="btn btn-gris"> VER MAS DETALLES </a></p>
            <?php } ?>

        </div>
    <?php } ?>
</div>