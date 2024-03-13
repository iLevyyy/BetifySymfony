<?php

namespace App\Controller;

use App\Entity\Artistas; // Ajustar el nombre de la entidad Artistas
use App\Entity\Canciones;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class DataController extends AbstractController
{
    /**
     * @Route("/insertar-datos-desde-json", name="insertar_datos_desde_json")
     */
    public function insertarDatosDesdeJson(EntityManagerInterface $entityManager)
    {
        // Eliminar todos los registros de la tabla Artistas
        $entityManager->createQuery('DELETE FROM App\Entity\Artistas')->execute();
        
        // Eliminar todos los registros de la tabla Canciones
        $entityManager->createQuery('DELETE FROM App\Entity\Canciones')->execute();
        
        // Reiniciar autoincremento de la tabla Artistas
        $entityManager->getConnection()->executeQuery('ALTER TABLE artistas AUTO_INCREMENT = 1');
        
        // Reiniciar autoincremento de la tabla Canciones
        $entityManager->getConnection()->executeQuery('ALTER TABLE canciones AUTO_INCREMENT = 1');
        
        // Ruta al archivo JSON
        $jsonFile = __DIR__ . '\storage\ranking.json';
        // Leer el archivo JSON
        $jsonData = file_get_contents($jsonFile);

        // Decodificar el JSON
        $data = json_decode($jsonData, true);

        // Array para mantener un registro de los artistas ya insertados
        $artistasInsertados = [];

        // Iterar sobre los datos y agregarlos a la base de datos
        foreach ($data as $item) {
            // Verificar si el artista ya ha sido insertado
            if (!in_array($item['Artista'], $artistasInsertados)) {
                // Buscar el artista por nombre
                $artista = $entityManager->getRepository(Artistas::class)->findOneBy(['nombre' => $item['Artista']]);

                // Si el artista no existe, crear uno nuevo
                if (!$artista) {
                    $artista = new Artistas();
                    $artista->setNombre($item['Artista']);
                    $entityManager->persist($artista);
                }

                // Agregar el artista al registro de artistas insertados
                $artistasInsertados[] = $item['Artista'];
            }

            // Crear la entidad Cancion y asignarle los datos
            $cancion = new Canciones();
            $cancion->setPuesto($item['Rango']);
            $cancion->setNombre($item['Cancion']);
            $cancion->setReproducciones($item['Reproducciones']);

            // Persistir la entidad Cancion
            $entityManager->persist($cancion);
        }

        // Flush para guardar los cambios en la base de datos
        $entityManager->flush();

        // Mensaje de éxito
        return new Response('Datos insertados exitosamente.');
    }
}
