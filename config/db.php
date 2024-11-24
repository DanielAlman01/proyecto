<?php
/*
Utilizamos una clase estatica para hacer la conexion al servidor
*/

class Database
{
    public static function connect()
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=proyecto_clasificados;charset=utf8', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configurarmos el modo de error
            return $db;
        } catch (PDOException $e) {
            // Manejo de excepciones con mensajes
            echo 'Error de conexión: ' . $e->getMessage();
            return null; // Retornamos null o manejamos el error de otra forma

        }
    }
}
