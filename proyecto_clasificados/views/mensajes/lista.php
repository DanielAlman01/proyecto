<div class="lista-conversaciones">
    <h2>Mis Conversaciones</h2>

    <?php if (count($conversaciones) > 0): ?>
        <ul>
            <?php foreach ($conversaciones as $conversacion): ?>
                <li>
                    <a href="<?= BASE_URL ?>mensaje/mostrar&id_anuncio=<?= $conversacion['id_anuncio'] ?>&id_receptor=<?= $conversacion['id_receptor'] ?>">
                        <strong><?= htmlspecialchars($conversacion['titulo_anuncio']) ?></strong> <br>
                        Último mensaje: <?= htmlspecialchars($conversacion['ultimo_mensaje']) ?> <br>
                        <small>Con: <?= htmlspecialchars($conversacion['nombre_receptor']) ?></small>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tienes conversaciones activas.</p>
    <?php endif; ?>
</div>
