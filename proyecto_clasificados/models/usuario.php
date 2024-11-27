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
    private $token;
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


    public function getToken()
    {
        return $this->token;
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


    public function setToken($token): void
    {
        $this->token = $token;
    }


    public function getUsuarios()
    {
        $usuarios = false;
        $sql = "SELECT * FROM  usuario ORDER BY id_usuario DESC";
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);

            if (!empty($usuarios)) {
                return $usuarios;
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        }
        $usuarios = false;
    }


    //Métodos para guardar datos
    public function salvar()
    {
        $correo = $this->getEmail();
            
        $sql = "UPDATE usuario SET estado_usuario=? WHERE email=? AND estado_usuario='ACTIVO'";
    
        $stmt = $this->db->prepare($sql);
    
        try {
            $stmt->execute(array($correo, $id_modifico, $id_usuario));
            
        
            return true;
        } catch (PDOException $e) {
            error_log("Error al cambiar el estado del usuario: " . $e->getMessage());
            return false;
        }
    }



 //Métodos para cambiar a clave temporal
 public function cambiarACT()
 {
     $sql = "INSERT INTO usuario (nombre_usuario, apellido_usuario, email, clave, tipo_usuario, estado_usuario, token) VALUES (:nombre_usuario, :apellido_usuario, :email, :clave, 'USUAL', 'INACTIVO', :token)";

     $stmt = $this->db->prepare($sql);

     $stmt->bindValue(':nombre_usuario', $this->getNombre_usuario());
     $stmt->bindValue(':apellido_usuario', $this->getApellido_usuario());
     $stmt->bindValue(':email', $this->getEmail());
     $stmt->bindValue(':clave', password_hash($this->getClave(), PASSWORD_BCRYPT));
     $stmt->bindValue(':token', $this->getToken());

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

public function cambiarEstado($e,$i, $m){
    $id_usuario = $i;
    $estado = $e;
    $id_modifico = $m;

    $sql = "UPDATE usuario SET estado_usuario=?, usuario_modifico=? WHERE id_usuario=?";

    $stmt = $this->db->prepare($sql);

    try {
        $stmt->execute(array($estado, $id_modifico, $id_usuario));
        
    
        return true;
    } catch (PDOException $e) {
        error_log("Error al cambiar el estado del usuario: " . $e->getMessage());
        return false;
    }
}



public function activarCuenta($token) {
    $sql = "UPDATE usuario SET estado_usuario = 'ACTIVO', token = NULL WHERE token = :token AND estado_usuario = 'INACTIVO'";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}




}
