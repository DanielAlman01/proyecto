<?php

require_once 'models/categoria.php';

class categoriaController
{
    public function index()
    {
        //Esto es para agregar categorias
        utils::isAdmin();  //Verificamos si es usuario tipo ADMIN
        $categoria = new categoria();
        $categorias = $categoria->getCategorias();
        //Obtenemos todas la categorias y las mostramos en la pagina de categorias
        require_once 'views/categorias/index.php';
    }


    public function verCategoriasAnuncios()
    {
        //Esto es para filtrar los anuncios por categoria
        $categoria = new categoria();
        $categorias = $categoria->getCategorias();
        require_once 'views/categorias/categoriaAnuncios.php';
    }


    public function  crear()
    {
        utils::isAdmin(); //Verificamos si es usuario tipo ADMIN
        //Mostramos la pagina para crea categorias
        require_once 'views/categorias/crear.php';
    }


    public function salvar()
    {
        //Si no es usuario tipo ADMIN se redirige a la pagina principal
        utils::isAdmin();

        try {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {

                $errores = []; //Creamos el arreglo errores para guardar los campos que no pasen la validacion

                //Sanitizamos y validamos los datos
                $nombre_categoria = htmlspecialchars(trim($_POST['nombre']));
                if (strlen($nombre_categoria) > 100) {
                    $errores['nombre_categoria'] = "El nombre no puede ser mayor a 100 caracteres.";
                }


                //Se verifica si hay datos en el arreglo de errores
                if (!empty($errores)) {
                    $_SESSION['errores'] = $errores;
                    $_SESSION['form_data'] = $_POST;
                    header('Location:' . BASE_URL . 'categoria/crear');
                    exit();
                }

                //Si no hay errores creamos el objeto y setiamos las variables necesarias
                $categoria = new categoria();
                $categoria->setNombre_categoria($nombre_categoria);
                $categoria->setUsuario_registra($_SESSION['identidad']->id_usuario);


                //Llamamos al modelo para guardar los datos
                if ($categoria->salvar()) {

                    //Si no surgen errores creamos un mensaje para indicar que el registro fue exitoso
                    $_SESSION['registro'] = "Completo";

                    //Limpiamos de igual forma cualquier rastro de mensaje de error en las variables correspondiente
                    unset($errores);
                    unset($_SESSION['form_data']);
                    unset($_SESSION['errores']);
                    header('Location:' . BASE_URL . 'categoria/index');
                    exit();
                } else {

                    //Si el registro no fue exitoso preparamos los mensajes y redirigimos
                    $_SESSION['registro'] = "Fallido";
                    $_SESSION['form_data'] = $_POST;
                    header('Location:' . BASE_URL . 'categoria/crea');
                    exit();
                }
            }
        } catch (Exception $e) {

            //Si el try falla preparamos los mensajes y redirigimos
            $_SESSION['registro'] = "Fallido";
            $_SESSION['form_data'] = $_POST;
            error_log(" Error " . $e->getMessage());
            header('Location:' . BASE_URL . 'categorias/crea');
            exit();
        }
    }
}
