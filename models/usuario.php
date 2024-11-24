<?php



class usuario
{
    private $id_usuario;
    private $nombre_usuario;
    private $apellido_usuario;
    private $email;
    private $clave;
    private $tipo_usuario;
    private $estado_usuario;
    private $fecha_registro;
    private $ultima_modificacion;
    private $usuario_modifico;

    private $db;




    //Mi constructor establece la conexion a la base de datos
    public function  __construct()
    {
        $this->db = Database::connect();
    }

    //Metodos para manipular los datos del objeto

    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    public function getNombre_usuario()
    {
        return $this->nombre_usuario;
    }

    public function getApellido_usuario()
    {
        return $this->apellido_usuario;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getTipo_usuario()
    {
        return $this->tipo_usuario;
    }

    public function getEstado_usuario()
    {
        return $this->estado_usuario;
    }

    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    public function getUltima_modificacion()
    {
        return $this->ultima_modificacion;
    }

    public function getUsuario_modifico()
    {
        return $this->usuario_modifico;
    }



    public function setId_usuario($id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function setNombre_usuario($nombre_usuario): void
    {

        $this->nombre_usuario = $nombre_usuario;
    }



    public function setApellido_usuario($apellido_usuario): void
    {

        $this->apellido_usuario = $apellido_usuario;
    }



    public function setEmail($email): void
    {

        $this->email = $email;
    }



    public function setClave($clave): void
    {

        $this->clave = $clave;
    }


    public function setTipo_usuario($tipo_usuario): void
    {
        $this->tipo_usuario = $tipo_usuario;
    }



    public function setEstado_usuario($estado_usuario): void
    {
        $this->estado_usuario = $estado_usuario;
    }



    public function setFecha_registro($fecha_registro): void
    {
        $this->fecha_registro = $fecha_registro;
    }



    public function setUltima_modificacion($ultima_modificacion): void
    {
        $this->ultima_modificacion = $ultima_modificacion;
    }



    public function setUsuario_modifico($usuario_modifico): void
    {
        $this->usuario_modifico = $usuario_modifico;
    }



    //Métodos para guardar datos
    public function salvar()
    {
        $sql = "INSERT INTO usuario (nombre_usuario, apellido_usuario, email, clave, tipo_usuario, estado_usuario) VALUES (:nombre_usuario, :apellido_usuario, :email, :clave, 'USUAL', 'ACTIVO')";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nombre_usuario', $this->getNombre_usuario());
        $stmt->bindValue(':apellido_usuario', $this->getApellido_usuario());
        $stmt->bindValue(':email', $this->getEmail());
        $stmt->bindValue(':clave', password_hash($this->getClave(), PASSWORD_BCRYPT));


        try {
            $stmt->execute();
            return true; // Retorna true si la inserción fue exitosa

        } catch (PDOException $e) {
            // Manejo del error
            error_log("Error: " . $e->getMessage());
            return false; // Retorna false si hubo un error
        }
    }

    //Método para hacer login
    public function login()
    {
        $resultado = false;
        $email = $this->getEmail();
        $password = $this->getClave();

        //Comprobamos si existe el usuario
        $sql = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->db->prepare($sql);

        //enlazo los datos
        $stmt->bindValue(':email', $email);


        try {

            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                //Si encontre el usuario devuelvo sus datos para verificar la password
                $datos =  $stmt->fetch(PDO::FETCH_OBJ);

                //verificamos la contraseña

                $verificacion = password_verify($password, $datos->clave);

                if ($verificacion) {
                    $resultado = $datos;
                }
            }
            return $resultado;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
}
