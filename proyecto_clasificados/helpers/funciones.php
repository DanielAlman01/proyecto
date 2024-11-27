
<?php

function generarClaveTemporal($longitud = 12) {
        // Conjunto de caracteres permitido
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $claveTemporal = '';
        $max = strlen($caracteres) - 1;
    
        // Generar la cadena de longitud especificada
        for ($i = 0; $i < $longitud; $i++) {
            $claveTemporal .= $caracteres[random_int(0, $max)];
        }
    
        return $claveTemporal;
    }