<?php
class Mensaje {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Guardar un mensaje
    public function guardarMensaje($id_anuncio, $id_remitente, $id_receptor, $mensaje) {
        $stmt = $this->db->prepare("INSERT INTO mensajes (id_anuncio, id_remitente, id_receptor, mensaje) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_anuncio, $id_remitente, $id_receptor, $mensaje]);
    }

    // Obtener los mensajes de un anuncio
    public function obtenerMensajes($id_anuncio) {
        $stmt = $this->db->prepare("SELECT m.*, u1.nombre_usuario AS emisor, u2.nombre_usuario AS receptor FROM mensajes m 
                                    JOIN usuario u1 ON m.id_remitente = u1.id_usuario
                                    JOIN usuario u2 ON m.id_receptor = u2.id_usuario
                                    WHERE m.id_anuncio = ? ORDER BY m.fecha_envio ASC");
        $stmt->execute([$id_anuncio]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>


