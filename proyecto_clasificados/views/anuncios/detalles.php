<section id="anuncio-detalle" class="section">
    <h2>Detalles del Anuncio</h2>


    <?php if (isset($datos) && !empty($datos) && is_object($datos)) { ?>
        <div class="card-container">
            <div class="card">
                <h3><?= htmlspecialchars($datos->titulo) ?></h3>
                <p><strong>Publicado por:</strong> <?= htmlspecialchars($datos->nombre_usuario) ?></p>
                <p><strong>Categoría:</strong> <?= htmlspecialchars($datos->nombre_categoria) ?></p>
                <p><strong>Ubicación:</strong> <?= htmlspecialchars($datos->ubicacion) ?></p>
                <p><strong>Descripción:</strong> <?= htmlspecialchars($datos->descripcion) ?></p>
                <p><strong>Precio:</strong> <?= htmlspecialchars($datos->precio) ?></p>



                <?php if (!empty($imagenes)) { ?>
                    <h2>Imágenes cargadas del Anuncio</h2>
                    <?php foreach ($imagenes as $img) { ?>
                        <div class="card">
                            <div class="card-container">
                                <img src="<?= BASE_URL . $img->ruta_imagen ?>" alt="Imagen del anuncio" width="150px" height="150px">
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="card-container">
                        <h2>En este anuncio no se cargaron imágenes</h2>
                        <img src="https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg?w=150" alt="Imagen predeterminada">
                    </div>
                <?php } ?>


                <p><strong>Fecha de Publicación:</strong> <?= htmlspecialchars($datos->fecha_publicacion) ?></p>
                <p><strong>Última Actualización:</strong> <?= htmlspecialchars($datos->ultima_modificacion ?? 'No disponible') ?></p>

                <?php if (isset($mensajes) && !empty($mensajes)): ?>
                    <div class="mensaje-container">
                        <h2 class="mensaje-title">Mensajes</h2>

                        <table class="mensaje-table">
                            <thead>
                                <tr>
                                    <th><strong>De:</strong></th>
                                    <th><strong>Para:</strong></th>
                                    <th><strong>Mensaje:</strong></th>
                                    <th><strong>Fecha:</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mensajes as $mensaje): ?>
                                    <tr class="mensaje-row">
                                        <td class="mensaje-sender"><?= htmlspecialchars($mensaje['emisor']); ?></td>
                                        <td class="mensaje-recipient"><?= htmlspecialchars($mensaje['receptor']); ?></td>
                                        <td class="mensaje-text"><?= htmlspecialchars($mensaje['mensaje']);  ?></td>
                                        <td class="mensaje-date"><?= $mensaje['fecha_envio']; ?></td>
                                    </tr>

                                    <tr></tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="no-messages">No hay mensajes para este anuncio.</p>
                <?php endif; ?>


                <?php if ($datos->id_usuario != $_SESSION['identidad']->id_usuario): ?>
                <!-- Formulario para enviar un mensaje -->
                <div class="mensaje-form-container">
                    <h4 class="mensaje-form-title">Enviar mensaje</h4>
                    <form method="POST" action="<?= BASE_URL ?>mensaje/enviarMensaje" class="mensaje-form">
                        <input type="hidden" name="id_anuncio" value="<?= $datos->id_anuncio; ?>">
                        <input type="hidden" name="id_remitente" value="<?= $_SESSION['identidad']->id_usuario; ?>">
                        <input type="hidden" name="id_receptor" value="<?= $datos->id_usuario; ?>"> <!-- El ID del receptor (vendedor) -->
                        <textarea name="mensaje" required class="mensaje-textarea"  placeholder="Escribe tu respuesta..." required></textarea><br>
                        <button type="submit" class="mensaje-submit-button">Enviar mensaje</button>
                    </form>
                </div>
                <?php endif; ?>
            <?php } ?>
            <a href="<?= BASE_URL ?>anuncio/index" class="btn btn-gris">Volver a los Anuncios</a>
</section>