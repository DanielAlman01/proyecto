<?php

require_once 'models/likes.php';

class LikesController {
    
    public function agregar() {
        header('Content-Type: application/json'); // Define el tipo de contenido como JSON
    
        try {
            // Validar que sea un método POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido', 405);
            }
    
            // Obtener datos necesarios
            $id_anuncio = $_POST['id_anuncio'] ?? null;
            $id_usuario = $_SESSION['identidad']->id_usuario ?? null;
    
            if (!$id_anuncio || !$id_usuario) {
                throw new Exception('Datos incompletos o usuario no autenticado', 400);
            }
    
            // Llamar al modelo para agregar el like
            $like = new Likes();
            $result = $like->darLike($id_anuncio, $id_usuario);
    
            if (!$result) {
                throw new Exception('No se pudo agregar el like. Intenta nuevamente.', 500);
            }
    
            // Respuesta JSON exitosa
            echo json_encode([
                'success' => true,
                'total_likes' => $result['total_likes']
            ]);
        } catch (Exception $e) {
            // Manejar errores y responder con un mensaje claro
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    
}
