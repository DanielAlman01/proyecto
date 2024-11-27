<div class="conversacion">
    <h2>Mensajes con el vendedor</h2>

    <!-- Mostrar mensajes -->
    <div id="mensaje-container">
        <?php if (!empty($mensajes)) : ?>
            <?php foreach ($mensajes as $mensaje) : ?>
                <div class="<?= $mensaje['id_remitente'] == $_SESSION['identidad']->id_usuario ? 'mensaje-enviado' : 'mensaje-recibido'; ?>">
                    <p><?= htmlspecialchars($mensaje['mensaje']) ?></p>
                    <small><?= $mensaje['fecha_envio'] ?></small>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No hay mensajes todavía.</p>
        <?php endif; ?>
    </div>

    <!-- Formulario para enviar mensajes -->
    <form id="form-enviar-mensaje">
        <input type="hidden" name="id_anuncio" value="<?= htmlspecialchars($_GET['id_anuncio']) ?>">
        <input type="hidden" name="id_receptor" value="<?= htmlspecialchars($_GET['id_receptor']) ?>">
        <textarea name="mensaje" id="mensaje" rows="3" placeholder="Escribe tu mensaje"></textarea>
        <button type="submit">Enviar</button>
    </form>
</div>

<script src="<?= BASE_URL ?>public/assets/mensajes.js"></script>
