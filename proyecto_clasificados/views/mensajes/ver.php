<!-- views/mensajes/ver.php -->
<h2>Conversación sobre el anuncio ID: <?= $id_anuncio ?></h2>

<div class="mensajes">
    <?php foreach ($mensajes as $mensaje): ?>
        <p><strong><?= $mensaje['id_remitente'] == $_SESSION['id_usuario'] ? 'Tú' : 'Vendedor' ?>:</strong> <?= htmlspecialchars($mensaje['mensaje']) ?></p>
    <?php endforeach; ?>
</div>

<form action="<?= BASE_URL ?>mensaje/enviar" method="POST">
    <input type="hidden" name="id_receptor" value="<?= $id_conversacion ?>">
    <input type="hidden" name="id_anuncio" value="<?= $id_anuncio ?>"> <!-- ID del anuncio -->
    <textarea name="mensaje" placeholder="Escribe tu respuesta..." required></textarea>
    <button type="submit">Enviar mensaje</button>
</form>
