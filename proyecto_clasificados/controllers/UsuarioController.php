<?php

require_once 'models/usuario.php';
require 'vendor/autoload.php'; 
require_once 'env_loader.php';
require_once 'helpers/utils.php';
require_once 'helpers/funciones.php';
// Cargar las variables de entorno
loadEnv('.env'); // Subimos un nivel para encontrar .env

use PHPMailer\PHPMailer\PHPMailer;


class usuarioController
{


    public function index()
    {
        //Esto es para listar e inhabilitar usuario
        utils::isAdmin();  //Verificamos si es usuario tipo ADMIN
        $usuario = new usuario();
        $usuarios = $usuario->getUsuarios();
        //Obtenemos todos ls usuarios 
        require_once 'views/usuarios/index.php';
    }


    public function registro()
    {
        require_once 'views/usuarios/registro.php';
    }


    public function salvar()
    {
        // Inicializar variables para repoblar el formulario
               
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario();
            $token = bin2hex(random_bytes(32)); // Generar token único


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
                $usuario->setToken($token);

                // Guarda el usuario en la base de datos
                if ($usuario->salvar()) {
                    $_SESSION['registro'] = "Completo";
                    $_SESSION['nombre_completo'] = $username . ' ' . $lastname;
                    $this->enviarCorreoActivacion($email, $token);
                    echo "<h2>Registro exitoso. Revisa tu correo para activar tu cuenta.</h2>";


                   // header('Location: ' . BASE_URL . 'usuario/login'); // Redirigir después de un registro exitoso
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






    private function enviarCorreoActivacion($email, $token) {

        
    $traerEmail = getenv('email_sistema');
    $passEmail= getenv('password_email');

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $traerEmail;
            $mail->Password = $passEmail;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Esto solo es temporal
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ),
            );
            

            $mail->setFrom($traerEmail, 'Sistema de Clasificados o Anuncios');
            $mail->addAddress($email);

            $url = BASE_URL."usuario/activar&token=" . $token;

            $mail->isHTML(true);
            $mail->Subject = 'Activa tu cuenta';
            $mail->Body = "Haz clic en el siguiente enlace para activar tu cuenta: <a href='$url'>$url</a>";

            $mail->send();
        } catch (Exception $e) {
            echo "Error al enviar correo: {$mail->ErrorInfo}";
        }


    }




    public function activar() {
        $token = $_GET['token'] ?? null;
        if ($token) {
            $usuario = new Usuario();
            if ($usuario->activarCuenta($token)) {
                echo "Cuenta activada con éxito. Ahora puedes iniciar sesión.";
            } else {
                echo "Token inválido o la cuenta ya fue activada.";
            }
        } else {
            echo "Token no proporcionado.";
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



    public function soliRecCla(){
        require_once 'views/usuarios/confSCC.php';
            
    }



    public function cerrarSession()
    {
        //Método para destruir la session
        session_unset();
        session_destroy();
        header("Location: " . BASE_URL);
    }

public function cambiarEstado(){
    if( isset($_GET['e']) && isset($_GET['i']) &&  utils::isAdmin()){
        $estado = $_GET['e'];
        $id_usuario = $_GET['i'];
        $modifica = $_SESSION['identidad']->id_usuario;
        $usuario = new usuario();
        $usuario->cambiarEstado($estado, $id_usuario, $modifica);
        header("Location: " . BASE_URL.'usuario/index');
    }

}

    public function clavTemp()
    {
        // Inicializar variables para repoblar el formulario

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario();
            $clave_temp = generarClaveTemporal();
            $token = bin2hex(random_bytes(32)); // Generar token único


            try {
                // Sanitizamos los datos de entrada            
                $email = isset($_POST['email']) ? trim($_POST['email']) : '';

                // Validar email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("El correo electrónico no es válido.");
                }

                // Si todo es válido, establece los valores en el modelo

                $usuario->setEmail($email);

                // Guarda el usuario en la base de datos
                if ($usuario->cambiarACT()) {

                    $this->enviarCorreoActivacion($email, $token);
                    echo "<h2>Cambio exitoso. Revisa tu correo para ver tu clave temporal.</h2>";

                    exit;
                } else {
                    $mensajeError = "No se pudo procesar el cambio.";
                }
            } catch (Exception $e) {

                $mensajeError = $e->getMessage(); // Guardar el mensaje de error
            }

            // Si hay un error, cargar de nuevo la vista

            header('Location: ' . BASE_URL . 'usuario/registro');
            exit;
        }
    }
}
