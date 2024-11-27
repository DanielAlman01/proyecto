<?php
class utils
{

    public static function borrarSession($name)
    {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
        return $name;
    }

    public static function isAdmin()
    {
        if (!isset($_SESSION['adm'])) {
            header('Location:' . BASE_URL);
        } else {
            return true;
        }
    }


    public static  function isSession()
    {
        $identidad = null;

        if (isset($_SESSION['identidad'])) {
            $identidad = $_SESSION['identidad'];
        }
        return $identidad;
    }

    
    
}
