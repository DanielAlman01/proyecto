
<h2>Eliminar Anuncios</h2>
<?php if (isset($_SESSION['registro']) && $_SESSION['registro'] === "Completo") : ?>
    <strong class="alert_green">Proceso exitoso</strong>
<?php endif; ?>

<?php utils::borrarSession('registro'); ?>

<table class="tabla_info">

    <?php if ($anuncios == false) : ?>
        <tr>
            <th>ID</th>
            <th>ANUNCIO</th>
            <th>CATEGORIA</th>
            <th>DESCRIPCION</th>
            <th>PUBLICADO</th>
            <th>ACCION</th>
        </tr>
        <tr>
            <td colspan="6">Noy hay anuncios registrados</td>
        </tr>
    <?php else : ?>

        <tr>
            <th>ID</th>
            <th>ANUNCIO</th>
            <th>CATEGORIA</th>
            <th>DESCRIPCION</th>
            <th>PUBLICADO</th>
            <th>ESTADO</th>
            <th>ACCION</th>
        </tr>
        <?php foreach ($anuncios as $anun) : ?>
            <tr>
                <td><?= $anun->id_anuncio; ?></td>
                <td><?= $anun->titulo; ?></td>
                <td><?= $anun->nombre_categoria; ?></td>
                <td><?= $anun->descripcion; ?></td>
                <td><?php $fecha = new Datetime($anun->fecha_publicacion);
                    echo $fecha->format('d-m-Y'); ?></td>
   <td><?= $anun->estado; ?></td>
                <td> 
                <?php if($anun->estado === "ACTIVO"){ ?>
                    <a href="<?= BASE_URL ?>anuncio/bajarAnuncio&id=<?= $anun->id_anuncio; ?>" class='btn btn-rojo'>BAJAR ANUNCIO</a>
                 <?php }elseif($anun->estado === "ELIMINADO") { ?>
                    <a href="<?= BASE_URL ?>anuncio/recuperarAnuncio&id=<?= $anun->id_anuncio; ?>" class='btn btn-verde'>RECUPERAR ANUNCIO</a>
                     <?php } ?>
                     </td>



            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>