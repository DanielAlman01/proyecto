<?php
session_start();
require_once 'autoload.php';
require_once 'config/db.php';
require_once 'config/parameters.php';
require_once 'helpers/utils.php';
require_once 'views/layout/header.php'; //Aqui cargamos  la cabecera de la pagina


//Aqui verificamos si existe el controlador
if (isset($_GET['controller'])) {

    $nombre_controlador = $_GET['controller'] . 'Controller';
} elseif (!isset($_GET['controller']) || !isset($_GET['action'])) {
    $nombre_controlador = CONTROLLER_DEFAULT;
} else {
    //echo 'Lo sentimos... La página que buscas no existe.  Error 001';
    $error =  new ErrorController();
    $error->index();
    //exit();
}


//Aqui verificamos si existe la clase
if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();

    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $action_default = ACTION_DEFAULT;
        $controlador->$action_default();
    } else {
        //echo 'Lo sentimos... La página que buscas no existe.  Error 002';
        $error =  new ErrorController();
        $error->index();
    }
} else {
    //echo 'Lo sentimos... La página que buscas no existe.  Error 003';
    $error =  new ErrorController();
    $error->index();
}


require_once 'views/layout/footer.php';  //Aqui cargamos el pie de la pagina
