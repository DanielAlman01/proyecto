<?php
require_once 'models/mensaje.php';

class mensajeController {
    
    // Mostrar el formulario de mensajes y los mensajes enviados
    public function detalles() {
        // Obtener los mensajes
        if(isset($_GET['id'])){
            $msg = new mensaje();
            $id_anuncio = (int)$_GET['id'];
            $mensajes = $msg->obtenerMensajes($id_anuncio);
            // Mostrar la vista
        require_once 'views/anuncios/detalles.php';
        }else{
            header("Location: ".BASE_URL."anuncio/verDetalles&id=$id_anuncio");
        }
        
        
        
    }

    // Enviar un mensaje
    public function enviarMensaje() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_anuncio = $_POST['id_anuncio'];
            $id_remitente = $_SESSION['identidad']->id_usuario; // Suponemos que el usuario está logueado
            $id_receptor = $_POST['id_receptor'];
            $mensaje = $_POST['mensaje'];
            $msg = new mensaje();
            // Guardar el mensaje
            $msg->guardarMensaje($id_anuncio, $id_remitente, $id_receptor, $mensaje);
            
            // Redirigir a la vista de detalles
            header("Location: " . BASE_URL . "anuncio/verDetalles&id=$id_anuncio");
            exit;
        }
    }

}
?>


