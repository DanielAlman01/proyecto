<?php
/*
En PHP, autoload es una funcionalidad que permite cargar automáticamente clases y archivos necesarios en el momento en que se utilizan, sin tener que incluirlos manualmente con require o include. Esto es especialmente útil en proyectos grandes con muchos archivos de clases, ya que evita cargar todos los archivos al inicio y mejora la eficiencia y organización del código.

En este caso cargará automaticamente los controladores
*/
function controllers_autoload($classname)
{
    include 'controllers/' . $classname . '.php';
}


spl_autoload_register('controllers_autoload');
