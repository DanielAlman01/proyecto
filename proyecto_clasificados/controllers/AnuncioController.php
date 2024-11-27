<?php
require_once 'models/anuncio.php';


class anuncioController
{
    public function index()
    {
       
        // Obtener los anuncios destacados
        $anunciosDestacados = new Anuncio(); // Instancia de la clase `Anuncio`
        $destacados = $anunciosDestacados->traerDestacados();

        $nuevosAnuncios = new Anuncio(); // Instancia de la clase `Anuncio`
        $nuevos = $anunciosDestacados->traerNuevos();


        // Validar si se obtuvieron anuncios
        if (!$destacados  || empty($destacados)) {
            $_SESSION['form_errores'] = ['anunciosDestacados' => 'No se encontraron anuncios destacados.'];
            $destacados = []; // Aseguramos que `$destacados` sea un array vacío 
        }

        // Validar si se obtuvieron anuncios
        if (!$nuevos  || empty($nuevos)) {
            $_SESSION['form_errores'] = ['anunciosNuevos' => 'No se encontraron anuncios nuevos.'];
            $nuevos = []; // Aseguramos que `$nuevos` sea un array vacío 
        }

        // Cargar la vista
        require_once 'views/anuncios/destacados.php';






    }


    public function  crear()
    {
        require_once 'models/categoria.php';
        $categorias = new categoria();
        $categoriasAnuncios = $categorias->getCategorias();
        require_once 'views/anuncios/crear.php';
    }


    public function salvarAnuncio()
    {

        // Inicializar un array para almacenar errores
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            try {

                // Sanitización y validación del título
                $titulo = htmlspecialchars(trim($_POST['titulo']));
                if (empty($titulo)) {
                    $errores['titulo'] = 'El título es obligatorio.';
                } elseif (strlen($titulo) > 100) {
                    $errores['titulo'] = 'El título no puede exceder los 100 caracteres.';
                }

                $descripcion = htmlspecialchars(trim($_POST['descripcion']));
                if (empty($descripcion)) {
                    $errores['descripcion'] = 'La descripción es obligatoria.';
                }

                $precio = trim($_POST['precio']);
                if (!empty($precio) && !preg_match('/^\d+(\.\d{1,2})?$/', $precio)) {
                    $errores['precio'] = 'El precio debe ser un número válido y puede tener hasta 2 decimales.';
                }

                $ubicacion = htmlspecialchars(trim($_POST['ubicacion']));
                if (empty($ubicacion)) {
                    $errores['ubicacion'] = 'La ubicación es obligatoria.';
                } elseif (strlen($ubicacion) > 255) {
                    $errores['ubicacion'] = 'El título no puede exceder los 255 caracteres.';
                }

                $id_categoria = (int)$_POST['id_categoria'];
                if (empty($id_categoria)) {
                    $errores['id_categoria'] = 'La categoría es obligatoria.';
                }


                // Subir las imágenes
                $imagenes = $_FILES['imagenes']; // Aquí obtenemos las imágenes enviadas


                // Comprobación si hay errores
                if (!empty($errores)) {

                    $_SESSION['form_errores'] = $errores;
                    $_SESSION['form_data'] = $_POST; // Guarda los datos ingresados en caso de error
                    header('Location: ' . BASE_URL . 'anuncio/crear'); // Redirigir al formulario
                    exit;
                }


                //si no hay errores guardamos el anuncio
                $anuncio = new anuncio();
                $anuncio->setId_usuario($_POST['id_usuario']);
                $anuncio->setId_categoria($id_categoria);
                $anuncio->setTitulo($titulo);
                $anuncio->setDescripcion($descripcion);
                $anuncio->setPrecio($precio);
                $anuncio->setUbicacion($ubicacion);
                $anuncio->setGusto(random_int(1,200));

                if ($anuncio->salvar()) {

                    header('Location: ' . BASE_URL . 'anuncio/gestionarMisAnuncios'); // Redirigir después de un registro exitoso
                    $_SESSION['registro'] = "Completo";
                    unset($_SESSION['form_data']);
                    unset($_SESSION['form_errores']);
                    exit;
                } else {

                    $_SESSION['registro'] = "Fallido";
                    header('Location:' . BASE_URL . 'categoria/crear');
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['registro'] = "Fallido";
                error_log(" Error " . $e->getMessage());
                header('Location:' . BASE_URL . 'categoria/crear');
                exit;
            }
        }
    }



    public function  editar()
    {
        require_once 'models/categoria.php';
        require_once 'models/imagen.php';

        //comprobamos el id que viene por GET
        if (isset($_GET['id'])) {

            $id_anuncio = (int)$_GET['id'];

            if (empty($id_anuncio)) {
                $errores['id_anuncio'] = 'No se detecto el anuncio.';
            }

            if (!empty($errores)) {
                $_SESSION['form_errores'] = $errores;
                header('Location: ' . BASE_URL . 'anuncios/gestionarMisAnuncios'); // Redirigir al formulario
                exit;
            }

            $categorias = new categoria();
            $categoriasAnuncios = $categorias->getCategorias();
            $anuncios = new anuncio();
            $anuncios->setId_anuncio($id_anuncio);
            $anuncio = $anuncios->traerUnAnuncio();
            $imgs = new imagen();
            $imagenes = $imgs->getImagen($id_anuncio);

            require_once 'views/anuncios/editar.php';
        } else {

            header('Location: ' . BASE_URL . 'anuncios/editar'); // Redirigir al formulario
            exit;
        }
    }



    public function  salvarEdicionAnuncio()
    {
       // Inicializar un array para almacenar errores
       $errores = [];

       if ($_SERVER['REQUEST_METHOD'] === "POST") {

           try {

               // Sanitización y validación del título
               $usuario_modifico = htmlspecialchars(trim($_POST['usuario_modifico']));
               if (empty($usuario_modifico)) {
                   $errores['usuario_modifico'] = 'El usuario no esta registrado.';
               }
               
               $id_anuncio = htmlspecialchars(trim($_POST['id_anuncio']));
               if (empty($id_anuncio)) {
                   $errores['id_anuncio'] = 'El Codigo de anuncio no valido.';
               } 


               $titulo = htmlspecialchars(trim($_POST['titulo']));
               if (empty($titulo)) {
                   $errores['titulo'] = 'El título es obligatorio.';
               } elseif (strlen($titulo) > 100) {
                   $errores['titulo'] = 'El título no puede exceder los 100 caracteres.';
               }

               $descripcion = htmlspecialchars(trim($_POST['descripcion']));
               if (empty($descripcion)) {
                   $errores['descripcion'] = 'La descripción es obligatoria.';
               }

               $precio = trim($_POST['precio']);
               if (!empty($precio) && !preg_match('/^\d+(\.\d{1,2})?$/', $precio)) {
                   $errores['precio'] = 'El precio debe ser un número válido y puede tener hasta 2 decimales.';
               }

               $ubicacion = htmlspecialchars(trim($_POST['ubicacion']));
               if (empty($ubicacion)) {
                   $errores['ubicacion'] = 'La ubicación es obligatoria.';
               } elseif (strlen($ubicacion) > 255) {
                   $errores['ubicacion'] = 'El título no puede exceder los 255 caracteres.';
               }

               $id_categoria = (int)$_POST['id_categoria'];
               if (empty($id_categoria)) {
                   $errores['id_categoria'] = 'La categoría es obligatoria.';
               }

               // Comprobación si hay errores
               if (!empty($errores)) {

                   $_SESSION['form_errores'] = $errores;
                   $_SESSION['form_data'] = $_POST; // Guarda los datos ingresados en caso de error
                   header('Location: ' . BASE_URL . 'anuncio/editar'); // Redirigir al formulario
                   exit;
               }


               //si no hay errores guardamos el anuncio
               $anuncio = new anuncio();
               $anuncio->setId_anuncio($id_anuncio);
               $anuncio->setUsuario_modifico($usuario_modifico);
               $anuncio->setId_categoria($id_categoria);
               $anuncio->setTitulo($titulo);
               $anuncio->setDescripcion($descripcion);
               $anuncio->setPrecio($precio);
               $anuncio->setUbicacion($ubicacion);
                           
               if ($anuncio->editar()) {

                   header('Location: ' . BASE_URL . 'anuncio/gestionarMisAnuncios'); // Redirigir después de un registro exitoso
                   
                   /*
                           // Eliminar imágenes seleccionadas
        if (isset($_POST['eliminar_imagenes'])) {
            $imagenModel = new Imagen();
            foreach ($_POST['eliminar_imagenes'] as $id_imagen) {
                $imagen = $imagenModel->traerImagen($id_imagen);
                if ($imagen) {
                    // Eliminar archivo físico
                    $rutaArchivo = 'uploads/' . $imagen->ruta_imagen;
                    if (file_exists($rutaArchivo)) {
                        unlink($rutaArchivo);
                    }
                    // Eliminar de la base de datos
                    $imagenModel->eliminarImagen($id_imagen);
                }
            }
        }
                    */
                    // Subir nuevas imágenes
                    if (!empty($_FILES['imagenes']['name'][0])) {
                        $files = $_FILES['imagenes'];
                        for ($i = 0; $i < count($files['name']); $i++) {
                            $tmp_name = $files['tmp_name'][$i];
                            $name = time() . '_' . $files['name'][$i];
                            $upload_path = 'uploads/' . $name;

                            if (move_uploaded_file($tmp_name, $upload_path)) {
                                $imagenModel = new Imagen();
                                $imagenModel->setId_anuncio($id_anuncio);
                                $imagenModel->setNombre_imagen($tmp_name);
                                $imagenModel->setRuta_imagen($upload_path);
                                $imagenModel->salvar();
                            }
                        }
                    }
                   
                   
                   $_SESSION['registro'] = "Completo";
                   unset($_SESSION['form_data']);
                   unset($_SESSION['form_errores']);
                   exit;
               } else {

                   $_SESSION['registro'] = "Fallido";
                   header('Location:' . BASE_URL . 'anuncio/editar');
                   exit();
               }
           } catch (Exception $e) {
               $_SESSION['registro'] = "Fallido";
               error_log(" Error " . $e->getMessage());
               header('Location:' . BASE_URL . 'anuncios/editar');
               exit;
           }
       }
   }



    public function gestionarMisAnuncios()
    {
        $anuncio = new anuncio();
        $anuncios = $anuncio->traerMisAnuncios();
        require_once 'views/anuncios/misAnuncios.php';
    }


    public function todosLosAnuncios()
    {
        utils::isAdmin();  //Verificamos si es usuario tipo ADMIN
        $anuncio = new anuncio();
        $anuncios = $anuncio->traerTodosLosAnuncios();
        require_once 'views/anuncios/listaAnuncios.php';
    }


    public function mostrarAnunciosXCategoria()
    {
        // Verificar si el ID de categoría está presente en el GET
        if (!isset($_GET['id'])) {
            $_SESSION['form_errores'] = ['id_categoria' => 'No se proporcionó una categoría válida.'];
            require_once 'views/anuncios/todosLosAnunciosCategoria.php';
            exit;
        }
    
        // Convertir el ID a entero
        $id_categoria = (int)$_GET['id'];
    
        // Validar el ID
        if ($id_categoria <= 0) {
            $_SESSION['form_errores'] = ['id_categoria' => 'El ID de categoría no es válido.'];
            require_once 'views/anuncios/todosLosAnunciosCategoria.php';
            exit;
        }
    
        // Obtener los anuncios de la categoría
        $datos = new Anuncio(); // Instancia de la clase `Anuncio`
        $datos->setId_categoria($id_categoria);
        $anuncios = $datos->traerTodosLosAnunciosXCategoria();
    
        // Validar si se obtuvieron anuncios
        if (!$anuncios || empty($anuncios)) {
            $_SESSION['form_errores'] = ['anuncios' => 'No se encontraron anuncios para esta categoría.'];
            $anuncios = []; // Aseguramos que `$anuncios` sea un array vacío 
        }
    
        // Cargar la vista
        require_once 'views/anuncios/todosLosAnunciosCategoria.php';
    }



    public function verDetalles()
    {
        require_once 'models/anuncio.php';
    
        if (!isset($_GET['id'])) {
            $_SESSION['form_errores'] = ['id_anuncio' => 'No se proporcionó una categoría válida.'];
            require_once 'views/anuncios/todosLosAnunciosCategoria.php';
            exit;
        }
    
        $id_anuncio = (int)$_GET['id'];
    
        if ($id_anuncio <= 0) {
            $_SESSION['form_errores'] = ['id_anuncio' => 'El ID de este anuncio no es válido.'];
            require_once 'views/anuncios/todosLosAnunciosCategoria.php';
            exit;
        }
    
        $detalles = new anuncio();
        $detalles->setId_anuncio($id_anuncio);
        
        $mensajes=$detalles->obtenerMensajes($id_anuncio); 

        $datos = $detalles->traerUnAnuncio();
        $imagenes = $detalles->traerImagenes($id_anuncio); // Obtener imágenes
    
        if (!$datos || empty($datos)) {
            $_SESSION['form_errores'] = ['anuncios' => 'No se encontraron datos de este anuncio.'];
            $datos = [];
        }
    
        // Si no hay imágenes, asignar un array vacío para evitar errores
        $imagenes = $imagenes ?? [];
    
        require_once 'views/anuncios/detalles.php';
    }
    


     public function elimAnuncio()
     {

        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {


                $id_anuncio = htmlspecialchars(trim($_GET['id']));
                $id_anuncio =   (int)$id_anuncio;
                
                if (empty($id_anuncio)) {
                    $errores['id_anuncio'] = 'El anuncio no se puede eliminar.';
                } 

                $elim = new anuncio();
                $elim->setId_anuncio($id_anuncio);
                $elim->setEstado('ELIMINADO');
                $elim->setUsuario_modifico($_SESSION['identidad']->id_usuario);
             
                if ($elim->eliminarAnuncio()){
                    header('Location:' . BASE_URL . 'anuncio/gestionarMisAnuncios');
                }

                if (!empty($errores)) {
                    $_SESSION['form_errores'] = $errores;
                    header('Location: ' . BASE_URL . 'anuncio/gestionarMisAnuncios'); // Redirigir al formulario
                    exit;
                }

        } else  {
            $_SESSION['registro'] = "Fallido";
            error_log(" Eliminacion fallida");
            header('Location:' . BASE_URL . 'anuncio/gestionarMisAnuncios');
            exit;
        }



     }

     public function recuperarAnuncio()
     {

        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {


                $id_anuncio = htmlspecialchars(trim($_GET['id']));
                $id_anuncio =   (int)$id_anuncio;
                
                if (empty($id_anuncio)) {
                    $errores['id_anuncio'] = 'El anuncio no se puede recuperar.';
                } 

                $elim = new anuncio();
                $elim->setId_anuncio($id_anuncio);
                $elim->setEstado('ACTIVO');
                $elim->setUsuario_modifico($_SESSION['identidad']->id_usuario);
             
                if ($elim->recuperarAnuncio()){
                    header('Location:' . BASE_URL . 'anuncio/todosLosAnuncios');
                }

                if (!empty($errores)) {
                    $_SESSION['form_errores'] = $errores;
                    header('Location: ' . BASE_URL . 'anuncio/todosLosAnuncios'); // Redirigir al formulario
                    exit;
                }

        } else  {
            $_SESSION['registro'] = "Fallido";
            error_log(" recuperacion fallida");
            header('Location:' . BASE_URL . 'anuncio/todosLosAnuncios');
            exit;
        }



     }

     public function bajarAnuncio()
     {

        if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {


                $id_anuncio = htmlspecialchars(trim($_GET['id']));
                $id_anuncio =   (int)$id_anuncio;
                
                if (empty($id_anuncio)) {
                    $errores['id_anuncio'] = 'El anuncio no se puede bajar.';
                } 

                $elim = new anuncio();
                $elim->setId_anuncio($id_anuncio);
                $elim->setEstado('ELIMINADO');
                $elim->setUsuario_modifico($_SESSION['identidad']->id_usuario);
             
                if ($elim->bajarAnuncio()){
                    header('Location:' . BASE_URL . 'anuncio/todosLosAnuncios');
                }

                if (!empty($errores)) {
                    $_SESSION['form_errores'] = $errores;
                    header('Location: ' . BASE_URL . 'anuncio/todosLosAnuncios'); // Redirigir al formulario
                    exit;
                }

        } else  {
            $_SESSION['registro'] = "Fallido";
            error_log(" Baja fallida");
            header('Location:' . BASE_URL . 'anuncio/todosLosAnuncios');
            exit;
        }



     }


     public function filtrarAnuncios() {
        // Verificar si existen los datos enviados desde el formulario
        if (isset($_POST['filtro']) && isset($_POST['valor'])) {
            $filtro = $_POST['filtro'];
            $valor = $_POST['valor'];
    
            // Llamar al modelo para obtener los resultados filtrados
            $anuncio = new anuncio();
            $resultados = $anuncio->traerXFiltro($filtro, $valor);
    
            // Enviar los resultados a la vista
            require_once("views/anuncios/buscar.php");
        } else {
            echo "Faltan parámetros para realizar el filtro.";
        }
    }
    

    public function buscar(){
    require_once("views/anuncios/buscar.php");
}

}
