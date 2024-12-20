<section id="featured" class="section">
    <h2>Buscar según la selección</h2>

    <form action="<?= BASE_URL ?>anuncio/filtrarAnuncios" method="POST" class="contact-form" enctype="multipart/form-data">
        <label for="filtro">Filtrar por:</label>
        <select name="filtro" id="filtro" required>
            <option value="">Seleccionar el filtro</option>
            <option value="1" <?= isset($_POST['filtro']) && $_POST['filtro'] == '1' ? 'selected' : '' ?>>Categoría</option>
            <option value="2" <?= isset($_POST['filtro']) && $_POST['filtro'] == '2' ? 'selected' : '' ?>>Título</option>
            <option value="3" <?= isset($_POST['filtro']) && $_POST['filtro'] == '3' ? 'selected' : '' ?>>Precio</option>
            <option value="4" <?= isset($_POST['filtro']) && $_POST['filtro'] == '4' ? 'selected' : '' ?>>Ubicación</option>
        </select>

        <label for="valor">Valor según filtro:</label>
        <input type="text" name="valor" id="valor" value="<?= isset($_POST['valor']) ? htmlspecialchars($_POST['valor']) : '' ?>" required>

        <button type="submit">Filtrar</button>
    </form>

    <?php if (isset($resultados)) : ?>
        <!-- Mostrar los anuncios filtrados -->
        <?php
        if(isset($resultados) && !empty($resultados)){
         $cards = $resultados;
         include("helpers/cards.php");
        }else{
            echo " <h3> Sin resultados  </h3>";
        }
        
       
        ?>
    <?php endif; ?>
</section>



<!--Fin de Contenido-->