<?php

namespace App\Controller;


use App\Entity\Usuarios;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\UsuariosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Config\DoctrineMigrations\StorageConfig;

class TopDailySongsController extends AbstractController
{
    /**
     * Read films from storage
     */
    public static function readRanking()
    {
        // Ruta al archivo JSON
        $rutaArchivoJSON = './storage/ranking.json';

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
    }
}
