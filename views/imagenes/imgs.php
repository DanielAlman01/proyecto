<?php 
           
            if (!empty($imagenes)) : ?>
                <?php foreach ($imagenes as $imagen) : ?>
                    <div class="imagen-item">
                        <img src="<?= BASE_URL.$imagen->ruta_imagen ?>" alt="Imagen del anuncio" width="100">
                        <label>
                            <input type="checkbox" name="eliminar_imagenes[]" value="<?= htmlspecialchars($imagen->id_imagen) ?>"> Eliminar
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No hay imágenes cargadas.</p>
            <?php endif; ?>
        </div>