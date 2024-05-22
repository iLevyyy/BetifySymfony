<?php

namespace App\Controller;

use App\Entity\Artistas; // Ajustar el nombre de la entidad Artistas
use App\Entity\Canciones;
use App\Entity\CancionesAuxiliar;
use App\Entity\CancionesDia1;
use App\Entity\CancionesDia2;
use App\Entity\CancionesDia3;
use App\Entity\Apuestas;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class DataController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
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
    public function getTop20DailySongs()
    {
        // Credenciales de la API de Spotify
        $client_id = '62c59ffd98ff48419f68487957a44b84';
        $client_secret = '59ae1ac04a9740bea1dc14569bfb3d99';

        // Autenticación y obtención del token de acceso
        $token_url = 'https://accounts.spotify.com/api/token';
        $auth_header = base64_encode($client_id . ':' . $client_secret);
        $auth_data = array(
            'grant_type' => 'client_credentials',
        );

        $auth_options = array(
            'http' => array(
                'header' => "Authorization: Basic $auth_header\r\n" . "Content-Type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($auth_data),
            ),
        );

        $auth_context = stream_context_create($auth_options);
        $auth_response = file_get_contents($token_url, false, $auth_context);
        $auth_result = json_decode($auth_response, true);
        $access_token = $auth_result['access_token'];

        // Petición para obtener las 10 canciones más escuchadas
        $api_url = 'https://api.spotify.com/v1/playlists/37i9dQZEVXbMDoHDwVN2tF/tracks?fields=items(track(name,artists(name)))&limit=10';
        $request_headers = array(
            'Authorization: Bearer ' . $access_token,
        );

        $curl = curl_init($api_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $data = json_decode($response, true);

        if (isset($data['items'])) {
            $puesto = 1;
            $songs = [];
            foreach ($data['items'] as $item) {
                $song = new Canciones();
                $song->setNombre($item['track']['name']);
                $song->setPuesto($puesto);
                $artista = '';
                foreach ($item['track']['artists'] as $key => $artist) {
                    $artista .= $artist['name'] . ', ';
                }
                $artista = rtrim($artista, ', ');
                $song->setArtista($artista);
                $puesto++;
                array_push($songs, $song);
            }
        }
        curl_close($curl);
        return $songs;
    }

    public  function updateTop20DailySongs()
    {
        $apuestas = $this->entityManager->getRepository(Apuestas::class)->findAll();
        $apuestasCount = count($apuestas);
        if ($apuestasCount == 0) {
            $oldSongs = $this->entityManager->getRepository(CancionesDia1::class)->findAll();
            foreach ($oldSongs as $oldSong) {
                $this->entityManager->remove($oldSong);
            }
            $this->entityManager->flush();

            $currentSongs = $this->entityManager->getRepository(Canciones::class)->findAll();
            $currentSongsClassed = $this->changeClass($currentSongs);
            foreach ($currentSongsClassed as $key => $song) {
                $this->entityManager->persist($song);
            }
            $this->entityManager->flush();

            $newOldSongs = $this->entityManager->getRepository(Canciones::class)->findAll();
            foreach ($newOldSongs as $key => $song) {
                $this->entityManager->remove($song);
            }
            $this->entityManager->flush();

            $newSongs = $this->getTop20DailySongs();
            foreach ($newSongs as $key => $newSong) {
                $this->entityManager->persist($newSong);
            }
            $this->entityManager->flush();

            $auxiliarSongs = $this->entityManager->getRepository(CancionesAuxiliar::class)->findAll();
            foreach ($auxiliarSongs as $key => $song) {
                $this->entityManager->remove($song);
            }
            $auxiliarSongsChangedClass =  $this->changeToAuxiliarClass($newSongs = $this->getTop20DailySongs());
            foreach ($auxiliarSongsChangedClass as $key => $song) {
                $this->entityManager->persist($song);
            }
            $this->entityManager->flush();
            return $this->json(['success' => true, 'message' => 'Canciones actualizadas correctamente',], Response::HTTP_OK);
        } else {
            $auxiliarSongs = $this->entityManager->getRepository(CancionesAuxiliar::class)->findAll();
            foreach ($auxiliarSongs as $key => $song) {
                $this->entityManager->remove($song);
            }
            $auxiliarSongsChangedClass =  $this->changeToAuxiliarClass($newSongs = $this->getTop20DailySongs());
            foreach ($auxiliarSongsChangedClass as $key => $song) {
                $this->entityManager->persist($song);
            }
            $this->entityManager->flush();
            return $this->json(['success' => true, 'message' => 'Hay apuestas pendientes, canciones auxiliares actualizadas',], Response::HTTP_OK);
        }
    }
    public function changeToAuxiliarClass($songs)
    {
        $changedSongs = array();
        foreach ($songs as $key => $song) {
            $changedSong = new CancionesAuxiliar();
            $changedSong->setNombre($song->getNombre());
            $changedSong->setPuesto($song->getPuesto());
            $changedSong->setArtista($song->getArtista());
            //$changedSong->setReproducciones($song->getReproducciones());
            array_push($changedSongs, $changedSong);
        }
        return $changedSongs;
    }
    public function changeClass($songs)
    {
        $changedSongs = array();
        foreach ($songs as $key => $song) {
            $changedSong = new CancionesDia1();
            $changedSong->setNombre($song->getNombre());
            $changedSong->setPuesto($song->getPuesto());
            $changedSong->setArtista($song->getArtista());
            //$changedSong->setReproducciones($song->getReproducciones());
            array_push($changedSongs, $changedSong);
        }
        return $changedSongs;
    }
    public function updateDailySongsRequest(Request $request)
    {
        $this->updateTop20DailySongs();
        return $this->json(['message' => 'Canciones actualizadas correctamente', 'success' => true], Response::HTTP_OK);
    }
    public function sendSongsCall(Request $request)
    {
        //$this->updateTop20DailySongs();  
        $canciones = $this->entityManager->getRepository(Canciones::class)->findAll();
        $cancionesBien = [];
        foreach ($canciones as $key => $cancion) {
            $cancionInfo = ["Puesto" => $cancion->getPuesto(), "Cancion" => $cancion->getNombre(), "Artista" => $cancion->getArtista()];
            array_push($cancionesBien, $cancionInfo);
        }
        return $this->json(['canciones' => $cancionesBien, 'success' => true], Response::HTTP_OK);
    }
}
