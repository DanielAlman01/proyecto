<?php


class Likes {
    
    private $id_like;
    private $id_anuncio;
    private $id_usuario;
    private $fecha;
    private $db;

    public function __construct() 
    {
        $this->db = Database::connect();
    }


    function public getId_like()
    {
        return $this->id_like;
    }


    public function getId_anuncio()
    {
        return $this->id_anuncio;
    }


    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    public function getFecha()
    { 
        return $this->fecha;
    }


    public function setId_like($id_like)
    {
        $this->id_like=$id_like;
    }


    public function setId_anuncio($id_anuncio)
    {
        $this->id_anuncio=$id_anuncio;
    }


    public function setId_usuario($id_usuario)
    {
        $this->id_usuario=$id_usuario;
    }


    public function setFecha($fecha)
    {
        $this->fecha=$fecha;
    }




    public function darLike($idAnuncio, $idUsuario) {
        try {
            // Intentar insertar el like
            $stmt = $this->db->prepare("INSERT IGNORE INTO likes (id_anuncio, id_usuario) VALUES (?, ?)");
            $stmt->execute([$idAnuncio, $idUsuario]);
    
            // Obtener el total de likes
            $stmt = $this->db->prepare("SELECT COUNT(*) AS total_likes FROM likes WHERE id_anuncio = ?");
            $stmt->execute([$idAnuncio]);
            $totalLikes = $stmt->fetch(PDO::FETCH_ASSOC)['total_likes'];
    
            return ['total_likes' => $totalLikes];
        } catch (PDOException $e) {
            error_log("Error al guardar el like - " . $e->getMessage());
            return false;
        }
    }
    

    }
