<?php
$identificacion = utils::isSession();
$v = 0;
?>

<!--Cabecera de pagina-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificados - UTP</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/assets/styles.css?<?= $v++; ?>">


</head>

<body>
    <div class="container">
        <header>
            <h1>Clasificad<span class="magnifying-glass">o</span>s - UTP</h1>
            <nav>
                <ul>
                    <li><a href="<?= BASE_URL ?>anuncio/index">Inicio</a></li>


                    <li>
                        <a href="#">Anuncios</a>
                        <ul class="dropdown">



                            <?php if (isset($identificacion) && $identificacion <> null) { ?>
                                <li><a href="<?= BASE_URL ?>anuncio/gestionarMisAnuncios">Registrar Anuncio</a></li>
                            <?php } ?>



                            <?php if (isset($identificacion)) { ?>
                                <li><a href="<?= BASE_URL ?>categoria/verCategoriasAnuncios">Ver Anuncios </a></li>
                            <?php } ?>



                        </ul>
                    </li>


                    <li>
                        <a href="<?= BASE_URL ?>anuncio/buscar">Buscar</a>
                   
                    </li>



                    <li><a href="<?= BASE_URL ?>contacto/contactanos">Contáctanos</a></li>


                    <?php if (isset($identificacion) && $identificacion->tipo_usuario === "ADM") { ?>

                        <li>
                            <a href="#">Gestión ADMIN</a>
                            <ul class="dropdown">
                                <li><a href="<?= BASE_URL ?>categoria/index">Crear Categorias</a></li>
                                <li><a href="#new">Eliminar Anuncios</a></li>
                                <li><a href="<?= BASE_URL ?>usuario/index">Inactivar Usuarios</a></li>
                          
                                <li><a href="#new">Ver Mensajes</a></li>
                            </ul>
                        </li>
                    <?php } ?>





                    <?php if (!isset($identificacion)) : ?>

                        <li><a href="<?= BASE_URL ?>usuario/registro">Regístrese</a></li>
                        <li><a href="<?= BASE_URL ?>usuario/login">Iniciar Sesión</a></li>

                    <?php else : ?>
                        <li>
                            <a href="#"><?= "" . $identificacion->nombre_usuario; ?></a>
                            <ul class="dropdown">
                                <li> <a href="<?= BASE_URL ?>usuario/cerrarSession">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

        </header>
        <!--Fin de cabecera de pagina-->

        <main>