<?php
//require 'vendor/autoload.php';

require_once 'env_loader.php';

// Cargar las variables de entorno
loadEnv('.env'); // Subimos un nivel para encontrar .env

/*
Utilizamos una clase estatica para hacer la conexion al servidor
*/

class Database
{
    public static function connect()
    {
        try {
            $host = getenv('host');
            $database = getenv('db');
            $pass = getenv('passw_user');
            $user = getenv('user_host');


            $db = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8',$user,$pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configurarmos el modo de error
            return $db;
        } catch (PDOException $e) {
            // Manejo de excepciones con mensajes
            echo 'Error de conexión: ' . $e->getMessage();
            return null; // Retornamos null o manejamos el error de otra forma

        }
    }
}
