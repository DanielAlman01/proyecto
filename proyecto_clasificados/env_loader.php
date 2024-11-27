<?php
// Cargar las variables de entorno desde un archivo .env
function loadEnv($file)
{
    // Verificar si el archivo .env existe
    if (!file_exists($file)) {
        die('No se pudo encontrar el archivo .env');
    }

    // Leer el archivo línea por línea
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Eliminar comentarios (líneas que comienzan con #)
        if (strpos($line, '#') === 0) {
            continue;
        }

        // Separar la línea en clave y valor
        list($key, $value) = explode('=', $line, 2);

        // Eliminar espacios innecesarios
        $key = trim($key);
        $value = trim($value);

        // Establecer la variable de entorno
        putenv("$key=$value");
    }
}

// Cargar las variables del archivo .env
loadEnv(__DIR__ . '/.env');


