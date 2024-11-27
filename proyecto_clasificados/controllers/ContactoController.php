<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class contactoController
{
    public function index()
    {
        echo "Controlador Mensaje No existe - Accion Index";
    }


    public function contactanos()
    {
        require_once 'views/mensajes/contactanos.php';
    }


    public function mensajeAdmin()
    {
        require __DIR__ . '/../vendor/autoload.php'; // Ruta del autoload de Composer

        // Verificar si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitizar y validar entradas
            $nombre = htmlspecialchars(trim($_POST['nombre']));
            $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
            $mensaje = htmlspecialchars(trim($_POST['mensaje']));

            // Validar campos obligatorios
            if (empty($nombre) || !$email || empty($mensaje)) {
                // Almacenar los datos en la sesión para conservarlos
                $_SESSION['form_data'] = [
                    'nombre' => $nombre,
                    'email' => $email,
                    'mensaje' => $mensaje,
                    'errors' => [
                        'nombre' => empty($nombre) ? 'El nombre es obligatorio.' : '',
                        'email' => !$email ? 'El correo electrónico es inválido.' : '',
                        'mensaje' => empty($mensaje) ? 'El mensaje no puede estar vacío.' : '',
                    ]
                ];
                $_SESSION['error'] = 'Por favor, completa todos los campos correctamente.';
                header('Location: ' . BASE_URL . 'mensaje/contactanos'); // Redirigir para mostrar errores
                exit;
            }

            // Configuración de PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kadaneville@gmail.com'; // Tu correo Gmail
                $mail->Password = 'rljn emdp cyge wccr'; // Tu contraseña o app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Configuración del remitente y destinatarios
                $mail->setFrom('kadaneville@gmail.com', 'Kadafy');

                // Agregar múltiples destinatarios
                $destinatarios = ['kadaneville@gmail.com', 'ghadafy.neville@utp.ac.pa'];
                foreach ($destinatarios as $destino) {
                    $mail->addAddress($destino);
                }

                // Configurar el contenido del correo
                $mail->isHTML(true);
                $mail->Subject = "Nuevo mensaje de contacto de $nombre";
                $mail->Body = "<h1>Mensaje de usuario del sitio CLASIFICADOS</h1>
                               <p><strong>Nombre:</strong> $nombre</p>
                               <p><strong>Email:</strong> $email</p>
                               <p><strong>Mensaje:</strong><br>$mensaje</p>";
                $mail->AltBody = "Nombre: $nombre\nEmail: $email\nMensaje: $mensaje";

                // Enviar el correo
                $mail->send();
                $_SESSION['success'] = 'Tu mensaje ha sido enviado exitosamente.';

                // Limpiar datos de sesión después de enviar con éxito
                unset($_SESSION['form_data']);
                header('Location: ' . BASE_URL . 'mensaje/contactanos'); // Redirigir a la misma página
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = "Ocurrió un problema al enviar tu mensaje. Error: {$mail->ErrorInfo}";
                header('Location: ' . BASE_URL . 'mensaje/contactanos'); // Redirigir a la misma página
                exit;
            }
        }
    }
}
