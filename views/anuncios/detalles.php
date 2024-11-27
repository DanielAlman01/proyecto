<section id="anuncio-detalle" class="section">
    <h2>Detalles del Anuncio</h2>

    <?php if (isset($datos) && !empty($datos) && is_object($datos)) { ?>
        <div class="card-container">
            <div class="card">
                <h3><?= htmlspecialchars($datos->titulo) ?></h3>
                <div>
                    <p><strong>Publicado por:</strong> <?= htmlspecialchars($datos->nombre_usuario) ?></p>
                    <p><strong>Categoría:</strong> <?= htmlspecialchars($datos->nombre_categoria) ?></p>
                    <p><strong>Ubicación:</strong> <?= htmlspecialchars($datos->ubicacion) ?></p>
                    <p><strong>Descripción:</strong> <?= htmlspecialchars($datos->descripcion) ?></p>
                    <p><strong>Precio:</strong> <?= htmlspecialchars($datos->precio) ?></p>
                </div>
                


                <?php if (!empty($imagenes)) { ?>
                    <h2>Imágenes cargadas del Anuncio</h2>
                    <div class="separacion-img">
                        <?php foreach ($imagenes as $img) { ?>
                            <div class="card">
                                <div class="card-container card-detalles_imagenes">
                                    <img src="<?= BASE_URL . $img->ruta_imagen ?>" alt="Imagen del anuncio" width="150px">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="card-container">
                        <h2>En este anuncio no se cargaron imágenes</h2>
                        <img src="https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg?w=150" alt="Imagen predeterminada">
                    </div>
                <?php } ?>


                <p><strong>Fecha de Publicación:</strong> <?= htmlspecialchars($datos->fecha_publicacion) ?></p>
                <p><strong>Última Actualización:</strong> <?= htmlspecialchars($datos->ultima_modificacion ?? 'No disponible') ?></p>
            </div>
        </div>
    <?php } ?>
    <a href="#" class="btn btn-gris">Volver a los Anuncios</a>
</section>