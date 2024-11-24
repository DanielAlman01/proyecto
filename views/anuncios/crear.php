<h2>Crear Nuevo Anuncio</h2>
<?php if (isset($_SESSION['registro']) && $_SESSION['registro'] === "Fallido") : ?>
    <strong class="alert_red">Registro fallido</strong>
<?php elseif (isset($_SESSION['registro']) && $_SESSION['registro'] === "Completo") : ?>
    <strong class="alert_green">Anuncio creado exitosamente.</strong>
<?php endif; ?>

<?php utils::borrarSession('registro');

// Guardamos los datos en caso de errores
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
$errores = isset($_SESSION['form_errores']) ? $_SESSION['form_errores'] : [];
?>

<div class="contact-section">

    <form action="<?= BASE_URL ?>anuncio/salvarAnuncio" method="POST" class="contact-form" enctype="multipart/form-data">
        <!-- Campo oculto de id_usuario -->
        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($_SESSION['identidad']->id_usuario) ?>">

        <label for="id_categoria">Categoría:</label>
        <select name="id_categoria" id="id_categoria" required>
            <option value="">Seleccionar categoría</option>
            <?php
            foreach ($categoriasAnuncios as $categoria) {
                $selected = (isset($formData['id_categoria']) && $formData['id_categoria'] == $categoria->id_categoria) ? 'selected' : '';
                echo "<option value=\"{$categoria->id_categoria}\" $selected>{$categoria->nombre_categoria}</option>";
            }
            ?>
        </select>
        <span class="error"><?= isset($errores['id_categoria']) ? $errores['id_categoria'] : '' ?></span>

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($formData['titulo'] ?? '') ?>" required>
        <span class="error"><?= isset($errores['titulo']) ? $errores['titulo'] : '' ?></span>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required><?= htmlspecialchars($formData['descripcion'] ?? '') ?></textarea>
        <span class="error"><?= isset($errores['descripcion']) ? $errores['descripcion'] : '' ?></span>

        <label for="precio">Precio (opcional):</label>
        <input type="text" name="precio" id="precio" value="<?= htmlspecialchars($formData['precio'] ?? '') ?>">

        <label for="ubicacion">Ubicación:</label>
        <input type="text" name="ubicacion" id="ubicacion" value="<?= htmlspecialchars($formData['ubicacion'] ?? '') ?>" required>
        <span class="error"><?= isset($errores['ubicacion']) ? $errores['ubicacion'] : '' ?></span>

        <label for="imagenes">Imágenes:</label>
        <input type="file" name="imagenes[]" id="imagenes" accept="image/*" multiple>
        <div id="imagenes-preview"></div> <!-- Contenedor para mostrar las imágenes seleccionadas -->
        <span class="error"><?= isset($errores['imagenes']) ? $errores['imagenes'] : '' ?></span>

        <button type="submit">Agregar Anuncio</button>
    </form>
</div>



<script>
    // Escuchar el evento cuando se seleccionan archivos en el input
    document.getElementById('imagenes').addEventListener('change', function (event) {
        // Limpiar el contenedor de imágenes previas antes de mostrar las nuevas
        const previewContainer = document.getElementById('imagenes-preview');
        previewContainer.innerHTML = ''; 

        // Obtener los archivos seleccionados
        const files = event.target.files;

        // Verificar si hay archivos seleccionados
        if (files.length > 0) {
            // Recorrer todos los archivos seleccionados
            Array.from(files).forEach(file => {
                // Crear un lector de archivos
                const reader = new FileReader();

                // Event listener para cuando se carga la imagen
                reader.onload = function(e) {
                    // Crear una imagen HTML
                    const img = document.createElement('img');
                    img.src = e.target.result; // Asignar la URL de la imagen cargada
                    img.style.maxWidth = '100px'; // Limitar el tamaño de la imagen
                    img.style.marginRight = '10px'; // Agregar espacio entre imágenes

                    // Agregar la imagen al contenedor de previsualización
                    previewContainer.appendChild(img);
                };

                // Leer el archivo como URL de datos
                reader.readAsDataURL(file);
            });
        }
    });
</script>
