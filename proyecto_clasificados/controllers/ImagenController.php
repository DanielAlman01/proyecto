<?php
require_once 'models/imagen.php';


class anuncioController
{

    public function  mostrarImagen($id)
    {
       
        $imgs = new imagen();
        $imagenes = $imgs->getImagen($id);
        require_once 'views/imagenes/imgs.php';
    }

}