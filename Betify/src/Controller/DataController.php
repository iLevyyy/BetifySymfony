<?php

namespace App\Controller;

use App\Entity\Artistas; // Ajustar el nombre de la entidad Artistas
use App\Entity\Canciones;
use App\Entity\CancionesDia1;
use App\Entity\CancionesDia2;
use App\Entity\CancionesDia3;
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
        $entityManager->createQuery('DELETE FROM App\Entity\Artistas')->execute();

        $entityManager->createQuery('DELETE FROM App\Entity\Canciones')->execute();

        $entityManager->getConnection()->executeQuery('ALTER TABLE artistas AUTO_INCREMENT = 1');

        $entityManager->getConnection()->executeQuery('ALTER TABLE canciones AUTO_INCREMENT = 1');
        $artistasInsertados = [];

        //Actual
        $jsonFile = __DIR__ . '\storage\ranking.json';
        $jsonData = file_get_contents($jsonFile);

        $data = json_decode($jsonData, true);

        foreach ($data as $item) {
            if (!in_array($item['Artista'], $artistasInsertados)) {
                $artista = $entityManager->getRepository(Artistas::class)->findOneBy(['nombre' => $item['Artista']]);

                if (!$artista) {
                    $artista = new Artistas();
                    $artista->setNombre($item['Artista']);
                    $entityManager->persist($artista);
                }

                $artistasInsertados[] = $item['Artista'];
            }

            $cancion = new Canciones();
            $cancion->setPuesto($item['Rango']);
            $cancion->setNombre($item['Cancion']);
            $cancion->setReproducciones($item['Reproducciones']);

            // Persistir la entidad Cancion
            $entityManager->persist($cancion);
        }

        $entityManager->createQuery('DELETE FROM App\Entity\CancionesDia1')->execute();

        $entityManager->getConnection()->executeQuery('ALTER TABLE cancionesdia1 AUTO_INCREMENT = 1');

        //Dia1
        $jsonFile1 = __DIR__ . '\storage\ranking1.json';
        $jsonData1 = file_get_contents($jsonFile1);

        $data1 = json_decode($jsonData1, true);

        foreach ($data1 as $item1) {
            if (!in_array($item1['Artista'], $artistasInsertados)) {
                $artista1 = $entityManager->getRepository(Artistas::class)->findOneBy(['nombre' => $item1['Artista']]);

                if (!$artista1) {
                    $artista1 = new Artistas();
                    $artista1->setNombre($item1['Artista']);
                    $entityManager->persist($artista1);
                }

                $artistasInsertados[] = $item1['Artista'];
            }

            $cancion1 = new CancionesDia1();
            $cancion1->setPuesto($item1['Rango']);
            $cancion1->setNombre($item1['Cancion']);
            $cancion1->setReproducciones($item1['Reproducciones']);

            // Persistir la entidad Cancion
            $entityManager->persist($cancion1);
        }

        $entityManager->createQuery('DELETE FROM App\Entity\CancionesDia2')->execute();

        $entityManager->getConnection()->executeQuery('ALTER TABLE cancionesdia2 AUTO_INCREMENT = 1');
        //Dia2
        $jsonFile2 = __DIR__ . '\storage\ranking2.json';
        $jsonData2 = file_get_contents($jsonFile2);

        $data2 = json_decode($jsonData2, true);

        foreach ($data2 as $item2) {
            if (!in_array($item2['Artista'], $artistasInsertados)) {
                $artista2 = $entityManager->getRepository(Artistas::class)->findOneBy(['nombre' => $item2['Artista']]);

                if (!$artista2) {
                    $artista2 = new Artistas();
                    $artista2->setNombre($item2['Artista']);
                    $entityManager->persist($artista2);
                }

                $artistasInsertados[] = $item2['Artista'];
            }

            $cancion2 = new CancionesDia2();
            $cancion2->setPuesto($item2['Rango']);
            $cancion2->setNombre($item2['Cancion']);
            $cancion2->setReproducciones($item2['Reproducciones']);

            // Persistir la entidad Cancion
            $entityManager->persist($cancion2);
        }


        $entityManager->createQuery('DELETE FROM App\Entity\CancionesDia3')->execute();

        $entityManager->getConnection()->executeQuery('ALTER TABLE cancionesdia3 AUTO_INCREMENT = 1');
        //Dia3
        $jsonFile3 = __DIR__ . '\storage\ranking3.json';
        $jsonData3 = file_get_contents($jsonFile3);

        $data3 = json_decode($jsonData3, true);

        foreach ($data3 as $item3) {
            if (!in_array($item3['Artista'], $artistasInsertados)) {
                $artista3 = $entityManager->getRepository(Artistas::class)->findOneBy(['nombre' => $item3['Artista']]);

                if (!$artista3) {
                    $artista3 = new Artistas();
                    $artista3->setNombre($item3['Artista']);
                    $entityManager->persist($artista3);
                }

                $artistasInsertados[] = $item3['Artista'];
            }

            $cancion3 = new CancionesDia3();
            $cancion3->setPuesto($item3['Rango']);
            $cancion3->setNombre($item3['Cancion']);
            $cancion3->setReproducciones($item3['Reproducciones']);

            // Persistir la entidad Cancion
            $entityManager->persist($cancion3);
        }

        // Flush para guardar los cambios en la base de datos
        $entityManager->flush();

        // Mensaje de éxito
        return new Response('Datos insertados exitosamente.');
    }
}
