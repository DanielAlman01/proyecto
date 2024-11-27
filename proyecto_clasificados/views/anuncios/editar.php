<h2>Editar Anuncio </h2>

<?php if (isset($_SESSION['registro']) && $_SESSION['registro'] === "Fallido") : ?>
    <strong class="alert_red">Registro fallido</strong>
<?php elseif (isset($_SESSION['registro']) && $_SESSION['registro'] === "Completo") : ?>
    <strong class="alert_green">Anuncio creado exitosamente.</strong>
<?php endif; ?>

<?php utils::borrarSession('registro');

//Aqui guardamos los datos en caso de errores y se necesiten nuevamente,  y tambien los mensajes de error en caso de existir
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$errores = isset($_SESSION['form_errores']) ? $_SESSION['form_errores'] : [];
?>


<div class="contact-section">

    <form action="<?= BASE_URL ?>anuncio/salvarEdicionAnuncio" method="POST" class="contact-form">
        <!-- Campo oculto de id_usuario -->
        <input type="hidden" name="usuario_modifico" value="<?= htmlspecialchars($_SESSION['identidad']->id_usuario) ?>">
        <input type="hidden" name="id_anuncio" value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) :  htmlspecialchars($formData['id_anuncio'])  ?>">
       
        <?php
            //var_dump($categoriasAnuncios);
            
            ?>

        <label for="id_categoria">Categoría:</label>
        <select name="id_categoria" id="id_categoria" required>
           
            <?php
          
            // Aquí se asume que $categorias contiene la lista de categorías de la base de datos
            foreach ($categoriasAnuncios as $categoria) {
                $selected = (isset($anuncio) && $anuncio->id_categoria == $categoria->id_categoria) ? 'selected' : ''; 
                echo "<option value=\"{$categoria->id_categoria}\" $selected>{$categoria->nombre_categoria}</option>";
            }
            ?>
        </select>
        <span class="error"><?= isset($errors['id_categoria']) ? $errors['id_categoria'] : '' ?></span>

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= isset($anuncio) ? htmlspecialchars($anuncio->titulo) : htmlspecialchars($formData['titulo']) ?>" required>
        <span class="error"><?= isset($errors['titulo']) ? $errors['titulo'] : '' ?></span>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required><?= isset($anuncio) ? htmlspecialchars($anuncio->descripcion) : htmlspecialchars($formData['descripcion']) ?></textarea>
        <span class="error"><?= isset($errors['descripcion']) ? $errors['descripcion'] : '' ?></span>

        <label for="precio">Precio (opcional):</label>
        <input type="text" name="precio" id="precio" value="<?= isset($anuncio) ? htmlspecialchars($anuncio->precio) : htmlspecialchars($formData['precio']) ?>">

        <label for="ubicacion">Ubicación:</label>
        <input type="text" name="ubicacion" id="ubicacion" value="<?= isset($anuncio) ? htmlspecialchars($anuncio->ubicacion) : htmlspecialchars($formData['ubicacion']) ?>" required>
        <span class="error"><?= isset($errors['ubicacion']) ? $errors['ubicacion'] : '' ?></span>


        <label for="imagenes_actuales">Imágenes actuales:</label>
        <div class="imagenes-actuales">
            <?php if (!empty($imagenes)) : ?>
                <?php foreach ($imagenes as $imagen) : ?>
                    <div class="imagen-item">
                    <img src="<?= BASE_URL . $imagen->ruta_imagen ?>" alt="<?= htmlspecialchars($imagen->titulo) ?>" width="200">
                        <label>
                            <input type="checkbox" name="eliminar_imagenes[]" value="<?= htmlspecialchars($imagen->id_imagen) ?>"> Eliminar
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No hay imágenes cargadas.</p>
            <?php endif; ?>
        </div>

        <label for="imagenes">Agregar nuevas imágenes:</label>
        <input type="file" name="imagenes[]" id="imagenes" multiple accept="image/*">




        <button type="submit">Modificar Anuncio</button>
        <a href="<?= BASE_URL ?>anuncio/gestionarMisAnuncios" class="btn btn-gris">CANCELAR</a>
    </form>
</div>