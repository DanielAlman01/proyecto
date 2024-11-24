<?php

require_once 'models/usuario.php';

class usuarioController
{
    public function index()
    {
        echo "Controlador Usuario No existe - Accion Index";
    }


    public function registro()
    {
        require_once 'views/usuarios/registro.php';
    }


    public function salvar()
    {
        // Inicializar variables para repoblar el formulario
        $username = '';
        $lastname = '';
        $email = '';
        $password = '';
        $confirmPassword = '';
        $mensajeError = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario();

            try {
                // Sanitizamos los datos de entrada
                $username = isset($_POST['username']) ? trim($_POST['username']) : '';
                $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
                $email = isset($_POST['email']) ? trim($_POST['email']) : '';
                $password = isset($_POST['password']) ? trim($_POST['password']) : '';
                $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

                // Validar nombre de usuario
                if (empty($username) || strlen($username) < 3 || strlen($username) > 25) {
                    throw new Exception("El nombre de usuario debe tener entre 3 y 25 caracteres.");
                }

                // Validar apellido
                if (empty($lastname) || strlen($lastname) < 3 || strlen($lastname) > 25) {
                    throw new Exception("El apellido debe tener entre 3 y 25 caracteres.");
                }

                // Validar email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("El correo electrónico no es válido.");
                }

                // Validar contraseña y confirmación
                if (strlen($password) < 6) {
                    throw new Exception("La contraseña debe tener al menos 6 caracteres.");
                }
                if ($password !== $confirmPassword) {
                    throw new Exception("Las contraseñas no coinciden.");
                }

                // Si todo es válido, establece los valores en el modelo
                $usuario->setNombre_usuario($username);
                $usuario->setApellido_usuario($lastname);
                $usuario->setEmail($email);
                $usuario->setClave($password);

                // Guarda el usuario en la base de datos
                if ($usuario->salvar()) {
                    $_SESSION['registro'] = "Completo";
                    $_SESSION['nombre_completo'] = $username . ' ' . $lastname;
                    header('Location: ' . BASE_URL . 'usuario/login'); // Redirigir después de un registro exitoso
                    unset($_SESSION['form_data']);
                    exit;
                } else {
                    $_SESSION['registro'] = "Fallido";
                    $mensajeError = "No se pudo registrar el usuario.";
                }
            } catch (Exception $e) {
                $_SESSION['registro'] = "Fallido";
                $mensajeError = $e->getMessage(); // Guardar el mensaje de error
            }

            // Si hay un error, cargar de nuevo la vista
            $_SESSION['error_mensaje'] = $mensajeError; // Guardar mensaje de error en sesión
            $_SESSION['form_data'] = [
                'username' => $username,
                'lastname' => $lastname,
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirmPassword,
            ];
            header('Location: ' . BASE_URL . 'usuario/registro');
            exit;
        }
    }


    public function login()
    {
        require_once 'views/usuarios/login.php';
    }


    public function identificarse()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //IDENTIFICAR EL USUARIO
            //CONSULTA A LA BASE DE DATOS 
            $usuario = new  usuario();
            $usuario->setEmail($_POST['email']);
            $usuario->setClave($_POST['password']);


            $identidad = $usuario->login();
            if ($identidad) {
                $_SESSION['identidad'] = $identidad;

                if ($identidad->tipo_usuario == 'ADM') {
                    $_SESSION['adm'] = true;
                }
                header('Location:' . BASE_URL . 'anuncio/index');
            } else {
                $_SESSION['error_login'] = 'Identificación fallida...';
                header('Location:' . BASE_URL . 'usuario/login');
            }
            //CREAR UNA SESION
        }
    }


    public function cerrarSession()
    {
        //Método para destruir la session
        session_unset();
        session_destroy();
        header("Location: " . BASE_URL);
    }
}
