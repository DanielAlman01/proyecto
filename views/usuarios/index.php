
<h2>Lista de Usuarios</h2>

<?php if (isset($_SESSION['registro']) && $_SESSION['registro'] === "Completo") : ?>
    <strong class="alert_green">Categoria creada correctamente</strong>
<?php endif; ?>

<?php utils::borrarSession('registro'); ?>

<table class="tabla_info">

    <?php if ($usuarios == false) : ?>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDO</th>
            <th>CORREO</th>
            <th>ESTADO</th>
            <th>ACCION</th>
        </tr>
        <tr>
            <td colspan="6">Noy hay usuarios registradas</td>
        </tr>
    <?php else : ?>

        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDO</th>
            <th>CORREO</th>
            <th>ESTADO</th>
            <th>ACCION</th>
        </tr>
        <?php foreach ($usuarios as $usu) : ?>
            <tr>
                <td><?= $usu->id_usuario; ?></td>
                <td><?= $usu->nombre_usuario; ?></td>
                <td><?= $usu->apellido_usuario; ?></td>
                <td><?= $usu->email; ?></td>
                <td><?= $usu->estado_usuario; ?></td>
                <td>
                    
                <?php if($usu->estado_usuario === "ACTIVO"){ ?>
                    <a href="<?= BASE_URL ?>usuario/cambiarEstado&i=<?= $usu->id_usuario; ?>&e=INACTIVO" class='btn btn-rojo'>INACTIVAR</a>
                 <?php }elseif($usu->estado_usuario === "INACTIVO") { ?>
                    <a href="<?= BASE_URL ?>usuario/cambiarEstado&i=<?= $usu->id_usuario; ?>&e=ACTIVO" class='btn btn-verde'>ACTIVAR</a>
                     <?php } ?>
                     </td> </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>