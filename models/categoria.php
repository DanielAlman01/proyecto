<?php

class categoria
{
    private $id_categoria;
    private $nombre_categoria;
    private $fecha_creacion;
    private $usuario_registra;
    private $ultima_modificacion;
    private $usuario_modifico;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }


    function getId_categoria()
    {
        return $this->id_categoria;
    }

    function getNombre_categoria()
    {
        return $this->nombre_categoria;
    }

    function getFecha_creacion()
    {
        return $this->fecha_creacion;
    }

    function getUsuario_registra()
    {
        return $this->usuario_registra;
    }

    function getUltima_modificacion()
    {
        return $this->ultima_modificacion;
    }

    function getUsuario_modifico()
    {
        return $this->usuario_modifico;
    }


    function setId_categoria($id_categoria): void
    {
        $this->id_categoria = $id_categoria;
    }

    function setNombre_categoria($nombre_categoria): void
    {
        $this->nombre_categoria = $nombre_categoria;
    }

    function setFecha_creacion($fecha_creacion): void
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setUsuario_registra($usuario_registra): void
    {
        $this->usuario_registra = $usuario_registra;
    }


    function setUltima_modificacion($ultima_modificacion): void
    {
        $this->ultima_modificacion = $ultima_modificacion;
    }

    function setUsuario_modifico($usuario_modifico): void
    {
        $this->usuario_modifico = $usuario_modifico;
    }



    public function getCategorias()
    {
        $categorias = false;
        $sql = "SELECT * FROM  categoria ORDER BY id_categoria DESC";
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute();
            $categorias = $stmt->fetchAll(PDO::FETCH_OBJ);

            if (!empty($categorias)) {
                return $categorias;
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        }
        $categorias = false;
    }


    //Métodos para guardar datos
    public function salvar()
    {
        $sql = "INSERT INTO categoria(nombre_categoria) VALUES (:nombre_categoria)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nombre_categoria', $this->getNombre_categoria());

        try {
            $stmt->execute();
            return true; // Retorna true si la inserción fue exitosa

        } catch (PDOException $e) {
            // Manejo del error
            error_log("Error: " . $e->getMessage());
            return false; // Retorna false si hubo un error
        }
    }
}
