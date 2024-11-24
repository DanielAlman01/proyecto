
<h2>Eliminar Anuncios</h2>
<?php if (isset($_SESSION['registro']) && $_SESSION['registro'] === "Completo") : ?>
    <strong class="alert_green">Anuncio creado correctamente</strong>
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
                <td> <a  onclick="return confirm('¿Estás seguro de que deseas eliminar el anuncio: <?= $anun->titulo; ?>?');" href="<?= BASE_URL ?>anuncio/elimAnuncio&id=<?= $anun->id_anuncio;  ?>" class="btn btn-rojo">ELIMINAR</a></td>
          

                <?php if($anu->estado_usuario === "ACTIVO"){ ?>
                    <a href="<?= BASE_URL ?>usuario/cambiarEstado&i=<?= $usu->id_usuario; ?>&e=INACTIVO" class='btn btn-rojo'>INACTIVAR</a>
                 <?php }elseif($usu->estado_usuario === "INACTIVO") { ?>
                    <a href="<?= BASE_URL ?>usuario/cambiarEstado&i=<?= $usu->id_usuario; ?>&e=ACTIVO" class='btn btn-verde'>ACTIVAR</a>
                     <?php } ?>
                     </td> </tr>



            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>