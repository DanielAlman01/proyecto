<?php



class anuncio
{
    private $id_anuncio;
    private $id_usuario;
    private $id_categoria;
    private $titulo;
    private $descripcion;
    private $precio;
    private $ubicacion;
    private $fecha_publicacion;
    private $ultima_modificacion;
    private $usuario_modifico;
    private $gusto;
    private $estado;
    private $db;


    public function __construct()
    {
        $this->db = Database::connect();
    }


    function getId_anuncio()
    {
        return $this->id_anuncio;
    }

    function getId_usuario()
    {
        return $this->id_usuario;
    }

    function getId_categoria()
    {
        return $this->id_categoria;
    }

    function getTitulo()
    {
        return $this->titulo;
    }

    function getDescripcion()
    {
        return $this->descripcion;
    }

    function getPrecio()
    {
        return $this->precio;
    }

    function getUbicacion()
    {
        return $this->ubicacion;
    }

    function getFecha_publicacion()
    {
        return $this->fecha_publicacion;
    }

    function getUltima_modificacion()
    {
        return $this->ultima_modificacion;
    }

    function getUsuario_modifico()
    {
        return $this->usuario_modifico;
    }

    function getGusto()
    {
        return $this->gusto;
    }

    function getEstado()
    {
        return $this->estado;
    }



    function setId_anuncio($id_anuncio): void
    {
        $this->id_anuncio = $id_anuncio;
    }

    function setId_usuario($id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    function setId_categoria($id_categoria): void
    {
        $this->id_categoria = $id_categoria;
    }

    function setTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }

    function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    function setPrecio($precio): void
    {
        $this->precio = $precio;
    }

    function setGusto($like): void
    {
        $this->gusto = $like;
    }



    function setUbicacion($ubicacion): void
    {
        $this->ubicacion = $ubicacion;
    }

    function setFecha_publicacion($fecha_publicacion): void
    {
        $this->fecha_publicacion = $fecha_publicacion;
    }

    function setUltima_modificacion($ultima_modificacion): void
    {
        $this->ultima_modificacion = $ultima_modificacion;
    }

    function setUsuario_modifico($usuario_modifico): void
    {
        $this->usuario_modifico = $usuario_modifico;
    }

    
    function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    public function traerUnAnuncio()
    {

        $id_anuncio = $this->getId_anuncio();

        $sql = " SELECT  a.id_anuncio, a.id_categoria, a.titulo, a.descripcion,  a.precio, 
        a.ubicacion, a.fecha_publicacion, a.ultima_modificacion, c.nombre_categoria, 
        u.nombre_usuario, u.email 
        FROM 
        anuncio a 
        JOIN 
        categoria c ON a.id_categoria = c.id_categoria 
        JOIN 
        usuario u ON a.id_usuario = u.id_usuario 
        WHERE 
        a.id_anuncio = ? 
        AND a.estado = 'ACTIVO' 
        ORDER BY 
        a.id_anuncio DESC";

        $stmt =  $this->db->prepare($sql);


        try {
            $stmt->execute(array($id_anuncio));
            // Obtener el resultado
            $anuncio = $stmt->fetch(PDO::FETCH_OBJ);
            if (!empty($anuncio)) {
                return $anuncio;
            }
        } catch (PDOException $e) {
            error_log("Error en traerMisAnuncios(): " . $e->getMessage());
        }
        return $anuncio;
    }


    public function traerMisAnuncios()
    {


        $anuncios = false;

        $sql  = "SELECT * FROM anuncio join categoria on anuncio.id_categoria=categoria.id_categoria WHERE id_usuario = :id_usuario and estado='ACTIVO' ORDER BY id_anuncio DESC";

        $stmt =  $this->db->prepare($sql);

        $stmt->bindValue(':id_usuario', $_SESSION['identidad']->id_usuario, PDO::PARAM_INT);

        try {
            $stmt->execute();
            // Obtener los resultados
            $anuncios = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($anuncios)) {
                return $anuncios;
            }
        } catch (PDOException $e) {
            error_log("Error en traerMisAnuncios(): " . $e->getMessage());
        }
        return $anuncios;
    }


    public function traerTodosLosAnunciosXCategoria()
    {

        $id_categoria=$this->getId_categoria();
        $anuncios = false;

        $sql = "SELECT 
        c.nombre_categoria, 
        a.id_anuncio, 
        a.titulo, 
        a.ubicacion, 
        a.gusto, 
        u.nombre_usuario, 
        u.email, 
        (SELECT i.ruta_imagen 
         FROM imagen i 
         WHERE i.id_anuncio = a.id_anuncio 
         LIMIT 1) AS ruta_imagen
    FROM 
        categoria c
    LEFT JOIN 
        anuncio a ON a.id_categoria = c.id_categoria AND a.estado = 'ACTIVO'
    LEFT JOIN 
        usuario u ON a.id_usuario = u.id_usuario
    WHERE 
        c.id_categoria = ?
    ORDER BY 
        a.id_anuncio DESC";



        $stmt =  $this->db->prepare($sql);


        try {
            $stmt->execute(array($id_categoria));
            // Obtener los resultados
            $anuncios = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($datos)) {
                $nombre_categoria = $datos[0]->nombre_categoria; // Siempre obtendrás el nombre de la categoría
            } else {
                $nombre_categoria = 'Categoría desconocida';
            }
        } catch (PDOException $e) {
            error_log("Error en traerTodosLosAnunciosXCategoria(): " . $e->getMessage());
        }
        return $anuncios;
    }


    public function traerImagenes($id)
    {
        $imagenes = [];
        $sql = "SELECT i.ruta_imagen FROM imagen i WHERE i.id_anuncio = ? ORDER BY id_imagen DESC";
    
        $stmt = $this->db->prepare($sql);
    
        try {
            $stmt->execute(array($id));
            $imagenes = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error en la carga de imágenes: " . $e->getMessage());
        }
    
        return $imagenes; // IMPORTANTE: Devolver el resultado
    }
    


    public function traerDestacados()
    {
        $anuncios = false;
    
        $sql = "SELECT 
        a.id_anuncio,
        a.titulo,
        a.descripcion,
        a.precio,
        a.ubicacion,
        a.fecha_publicacion,
        a.gusto,
        u.nombre_usuario,
        u.email,
        (SELECT i.ruta_imagen 
         FROM imagen i 
         WHERE i.id_anuncio = a.id_anuncio 
         LIMIT 1) AS ruta_imagen
            FROM 
                anuncio a
            LEFT JOIN 
                usuario u ON a.id_usuario = u.id_usuario
            WHERE 
                a.estado = 'ACTIVO' AND
                a.gusto >0
            GROUP BY 
                a.id_anuncio
            ORDER BY 
                a.gusto DESC, 
                a.fecha_publicacion DESC 
            LIMIT 9";
    
        $stmt = $this->db->prepare($sql);
    
        try {
            $stmt->execute();
            // Obtener los resultados
            $anuncios = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error en destacados: " . $e->getMessage());
        }
    
        return $anuncios;
    }
    


    public function traerNuevos()
    {

        $id_categoria=$this->getId_categoria();
        $anuncios = false;

        $sql = "SELECT 
                c.nombre_categoria, 
                a.id_anuncio, 
                a.titulo, 
                a.ubicacion, 
                a.fecha_publicacion,
                a.gusto,  
                u.nombre_usuario, 
                u.email,
                (SELECT i.ruta_imagen 
                FROM imagen i 
                WHERE i.id_anuncio = a.id_anuncio 
                LIMIT 1) AS ruta_imagen
                FROM 
                categoria c
                LEFT JOIN 
                anuncio a ON a.id_categoria = c.id_categoria AND a.estado = 'ACTIVO'
                LEFT JOIN 
                usuario u ON a.id_usuario = u.id_usuario
                WHERE 
                a.fecha_publicacion >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                GROUP BY 
                a.id_anuncio
                ORDER BY 
                a.gusto DESC, 
                a.id_anuncio DESC;
    ";
      

        $stmt =  $this->db->prepare($sql);

        try {
            $stmt->execute();
            // Obtener los resultados
            $anuncios = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($datos)) {
                $nombre_categoria = $datos[0]->nombre_categoria; // Siempre obtendrás el nombre de la categoría
            } else {
                $nombre_categoria = 'Categoría desconocida';
            }
        } catch (PDOException $e) {
            error_log("Error en destacados: " . $e->getMessage());
        }
        return $anuncios;
    }


    public function traerXFiltro($filtro, $valor) {
        $anuncios = false;
    
        // Mapeo de filtros
        $filtros = [
            '1' => 'nombre_categoria',
            '2' => 'titulo',
            '3' => 'precio',
            '4' => 'ubicacion'
        ];
    
        if (!isset($filtros[$filtro])) {
            return []; // Retorna un arreglo vacío si el filtro no es válido
        }
    
        $columna = $filtros[$filtro];
        $condicion = ($filtro == '3') ? "$columna = ?" : "$columna LIKE ?"; // Comparación exacta para precio, LIKE para los demás
    
        $sql = "
            SELECT 
                a.id_anuncio,
                a.titulo,
                a.descripcion,
                a.precio,
                a.ubicacion,
                a.fecha_publicacion,
                a.gusto,
                u.nombre_usuario,
                u.email,
                (SELECT i.ruta_imagen 
                 FROM imagen i 
                 WHERE i.id_anuncio = a.id_anuncio 
                 LIMIT 1) AS ruta_imagen
            FROM 
                anuncio a
            LEFT JOIN 
                usuario u ON a.id_usuario = u.id_usuario
            WHERE 
                a.estado = 'ACTIVO' AND
                $condicion
            GROUP BY 
                a.id_anuncio
            ORDER BY 
                a.gusto DESC, 
                a.fecha_publicacion DESC
        ";
    
        try {
            $stmt = $this->db->prepare($sql);
            $param = ($filtro == '3') ? $valor : "%$valor%"; // Agrega comodines para LIKE
            $stmt->execute([$param]);
            $anuncios = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error en traerXFiltro: " . $e->getMessage());
        }
    
        return $anuncios;
    }
    

    public function salvar()
    {
        require_once("models/imagen.php");

        $sql = "INSERT INTO anuncio (id_usuario, id_categoria, titulo, descripcion, precio, ubicacion) VALUES (:id_usuario, :id_categoria, :titulo, :descripcion, :precio, :ubicacion)";

        $stmt = $this->db->prepare($sql);

        $id_usuario =  $this->getId_usuario();
        $id_categoria = $this->getId_categoria();
        $titulo = $this->getTitulo();
        $descripcion = $this->getDescripcion();
        $precio = $this->getPrecio() ?: null;
        $ubicacion = $this->getUbicacion();
        $imagenes = $_FILES['imagenes']; // Aquí obtenemos las imágenes enviadas

        // Los datos del formulario han sido validados y sanitizados
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
        $stmt->bindParam(':ubicacion', $ubicacion, PDO::PARAM_STR);

        try {
            $registro = $stmt->execute();

            if ($registro) {
                // Obtener el ID del anuncio recién creado
                $id_anuncio = $this->db->lastInsertId();

                // Si se suben imágenes, las procesamos y las guardamos
                if (!empty($imagenes['name'][0])) {
                    $uploadDir = 'uploads/';  // Carpeta donde se guardarán las imágenes
                    foreach ($imagenes['tmp_name'] as $key => $tmp_name) {
                        $imageName = time() . '_' . basename($imagenes['name'][$key]);
                        $imagePath = $uploadDir . $imageName;

                        // Mover la imagen al directorio de uploads
                        if (move_uploaded_file($tmp_name, $imagePath)) {
                            // Guardar la ruta de la imagen en la tabla 'imagen' asociada al anuncio
                            $img = new Imagen();
                            $img->setId_anuncio($id_anuncio);
                            $img->setRuta_imagen($imagePath);
                            $img->setNombre_imagen($imageName);
                            $img->salvar();                            
                        }
                    }
                }
            }


            return true;
        } catch (PDOException $e) {
            error_log("Error al agregar el anuncio en Salvar(): " . $e->getMessage());
            return false;
        }
    }


    public function editar()
    {

        $id_anuncio = $this->getId_anuncio();
        $id_categoria = $this->getId_categoria();
        $titulo = $this->getTitulo();
        $descripcion = $this->getDescripcion();
        $precio = $this->getPrecio();
        $ubicacion = $this->getUbicacion();
        $usuario_modifico = $this->getUsuario_modifico();


        $sql = "UPDATE anuncio SET id_categoria=?, titulo=?, descripcion=?, precio=?, ubicacion=?, usuario_modifico=? WHERE id_anuncio=? and estado='ACTIVO' ";

        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute(array($id_categoria, $titulo, $descripcion, $precio, $ubicacion, $usuario_modifico, $id_anuncio));
            
            
            
            
            
            return true;
        } catch (PDOException $e) {
            error_log("Error al editar el anuncio: " . $e->getMessage());
            return false;
        }
    }


    public function eliminarAnuncio()
    {

        $id_anuncio = $this->getId_anuncio();
        $estado = $this->getEstado();
        $usuario_modifico = $this->getUsuario_modifico();

        $sql = "UPDATE anuncio SET estado=?, usuario_modifico=? WHERE id_anuncio=? and estado='ACTIVO' ";

        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute(array($estado, $usuario_modifico, $id_anuncio));
            return true;
        } catch (PDOException $e) {
            error_log("Error al eliminar el anuncio: " . $e->getMessage());
            return false;
        }
    }



}
