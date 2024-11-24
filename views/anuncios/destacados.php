<!--Contenido-->
<section id="featured" class="section">
 
    <?php 
    $cards = $destacados;
    if($cards) {
        echo "<h2>Anuncios mas Destacados</h2>";
        include("helpers/cards.php"); 
   }
    ?>

</section>

<section id="new" class="section">

    <?php 
    $cards = $nuevos;
if($cards) {
        echo "<h2>Nuenos Anuncios</h2>";
        include("helpers/cards.php"); 
   }
   ?>


</section>


<!--Fin de Contenido-->