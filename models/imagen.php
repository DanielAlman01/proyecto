<?php

class imagen
{
    private $id_imagen;
    private $id_anuncio;
    private $ruta_imagen;
    private $nombre_imagen;
    private $fecha_registro;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }


    function getId_imagen()
    {
        return $this->id_imagen;
    }


    function getId_anuncio()
    {
        return $this->id_anuncio;
    }

    function getNombre_imagen()
    {
        return $this->nombre_imagen;
    }

    function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    function getRuta_imagen()
    {
        return $this->ruta_imagen;
    }



    function setId_imagen($id_imagen): void
    {
        $this->id_imagen = $id_imagen;
    }

    function setId_anuncio($id_anuncio): void
    {
        $this->id_anuncio = $id_anuncio;
    }


    function setNombre_imagen($nombre_imagen): void
    {
        $this->nombre_imagen = $nombre_imagen;
    }

    function setRuta_imagen($ruta_imagen): void
    {
        $this->ruta_imagen = $ruta_imagen;
    }

    function setFecha_registro($fecha_registro): void
    {
        $this->fecha_registro = $fecha_registro;
    }






    public function getImagen($id)
    {
        $imagenes = false;

        $id_anuncio =$id;
        $sql = "SELECT * FROM  imagen WHERE id_anuncio=? ORDER BY id_imagen DESC";
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute(array($id_anuncio));
            $imagenes = $stmt->fetchAll(PDO::FETCH_OBJ);

            if (!empty($imagenes)) {
                return $imagenes;
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        }
        $imagenes = false;
    }


    //Métodos para guardar datos
    public function salvar()
    {
        $id_anuncio = $this->getId_anuncio();
        $ruta_imagen = $this->getRuta_imagen();
        $nombre_imagen = $this->getNombre_imagen();
        $sql = "INSERT INTO imagen(id_anuncio, ruta_imagen, nombre_imagen) VALUES (?,?,?)";

        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute(array($id_anuncio, $ruta_imagen, $nombre_imagen));
            return true; // Retorna true si la inserción fue exitosa

        } catch (PDOException $e) {
            // Manejo del error
            error_log("Error insertando imagen: " . $e->getMessage());
            return false; // Retorna false si hubo un error
        }
    }


    public function eliminarImagen()
    {

        $id_anuncio = $this->getId_anuncio();
        $estado = "ELIMINADO";
        

        $sql = "UPDATE imagen SET estado=? WHERE id_imagen=? and estado='ACTIVO' ";

        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute(array($estado, $id_anuncio));
            return true;
        } catch (PDOException $e) {
            error_log("Error al eliminar IMAGEN: " . $e->getMessage());
            return false;
        }
    }



}
