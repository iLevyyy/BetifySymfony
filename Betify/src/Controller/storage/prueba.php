<?php
// Ruta al archivo JSON
$rutaArchivoJSON = 'ranking.json';

// Lee el contenido del archivo JSON
$contenidoJSON = file_get_contents($rutaArchivoJSON);

// Decodifica el contenido JSON en un array asociativo de PHP
$arrayDatos = json_decode($contenidoJSON, true);

// Verifica si la decodificación fue exitosa
if ($arrayDatos === null) {
    echo "Error al decodificar el archivo JSON.";
} else {
    // La decodificación fue exitosa, muestra los datos
    echo "Datos leídos del archivo JSON:\n";
    print_r($arrayDatos);
}

?>