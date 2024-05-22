<?php

namespace App\Controller;

use App\Entity\Apuestas;
use App\Entity\Artistas;
use App\Entity\Canciones;
use App\Entity\CancionesDia1;
use App\Entity\CancionesDia2;
use App\Entity\CancionesDia3;
use App\Entity\CancionesWeek;
use App\Entity\Usuarios;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class ApuestasController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function listarApuestas(ManagerRegistry $managerRegistry): JsonResponse
    {
        $Apuestas = $managerRegistry->getRepository(Apuestas::class)->findAll();

        $ApuestasArray = [];
        foreach ($Apuestas as $Apuesta) {
            $ApuestasArray[] = [
                'cuota' => $Apuesta->getCuota(),
                'cantidad' => $Apuesta->getCantidad(),
                'fechafinal' => $Apuesta->getFechaFinal(),
                'artistasIdartista' => $Apuesta->getArtistasIdArtista()->getNombre(),
                'cancionesIdcancion' => $Apuesta->getcancionesIdCancion()->getNombre(),
            ];
        }

        return new JsonResponse($ApuestasArray);
    }

    public function crearApuesta(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $apuesta = new Apuestas();

        $apuesta->setCuota($data['Cuota']);
        $apuesta->setCantidad($data['Cantidad']);
        $apuesta->setPrediccion($data['Prediccion']);
        $apuesta->setFechaFinal($apuesta->createFechaFinal());
        $apuesta->setTipo($data['Tipo']);

        // Obtener la canción
        $cancion = $this->entityManager->getRepository(Canciones::class)->findOneBy(['nombre' => $data['Cancion']]);
        $apuesta->setCancionesIdcancion($cancion);

        // Obtener el usuario
        $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['token']]);

        // Verificar créditos
        if ($apuesta->getCantidad() > $usuario->getCreditos()) {
            return $this->json(['mensaje' => 'No se pueden apostar más créditos de los disponibles', 'success' => false, 'creditos' => $usuario->getCreditos(),], Response::HTTP_OK);
        }
        $usuario->setCreditos($usuario->getCreditos() - $apuesta->getCantidad());

        // Relacionar apuesta con usuario
        $usuario->addApuesta($apuesta);

        $this->entityManager->persist($apuesta);
        $this->entityManager->persist($usuario); // Persistir también el usuario para actualizar la relación
        $this->entityManager->flush();

        return $this->json(['mensaje' => 'Apuesta creada correctamente', 'success' => true, 'creditos' => $usuario->getCreditos()], Response::HTTP_OK);
    }


    public function getSongs()
    {
        $cancionesDia0 = $this->entityManager->getRepository(Canciones::class)->findAll();
        $cancionesDia1 = $this->entityManager->getRepository(CancionesDia1::class)->findAll();
        $cancionesDia2 = $this->entityManager->getRepository(CancionesDia2::class)->findAll();
        $cancionesDia3 = $this->entityManager->getRepository(CancionesDia3::class)->findAll();

        $allSongs = [];
        $allSongs[0] = [$cancionesDia0];
        $allSongs[1] = [$cancionesDia1];
        $allSongs[2] = [$cancionesDia2];
        $allSongs[3] = [$cancionesDia3];

        return ($allSongs);
    }

    public function calcularCuota(EntityManagerInterface $entityManager)
    {
        $algoritmoController = new AlgoritmoController($entityManager); // Asegúrate de haber obtenido $entityManager de alguna manera
        $allSongs = $algoritmoController->getSongs();
        $nombresDia0 = [];
        for ($i = 0; $i < 10; $i++) {  //Guarda los nombres de las 10 canciones a buscar
            $nombre = $allSongs[0][0][$i]->getNombre();
            array_push($nombresDia0, $nombre);
        }
        for ($i = 0; $i < sizeof($allSongs); $i++) {
            $allSongs[$i][0];
        }
        for ($i = 0; $i < 10; $i++) {
            if ($nombresDia0[$i]);
        }
    }

    public function checkSongPosition(EntityManagerInterface $entityManager)
    {
        $algoritmoController = new AlgoritmoController($entityManager); // Asegúrate de haber obtenido $entityManager de alguna manera
        $allSongs = $algoritmoController->getSongs();
        $nombresDia0 = [];
        for ($i = 0; $i < 10; $i++) {  //Guarda los nombres de las 10 canciones a buscar
            $nombre = $allSongs[0][0][$i]->getNombre();
            array_push($nombresDia0, $nombre);
        }
        $nombresDia1 = []; //Guarda los nombres de las 10 canciones del día anterior
        for ($i = 0; $i < 10; $i++) {  //Guarda los nombres de las 10 canciones a buscar
            $nombre = $allSongs[1][0][$i]->getNombre();
            array_push($nombresDia1, $nombre);
        }
        $resultados = [
            "up" => [],
            "down" => [],
            "stay" => []
        ];

        for ($i = 0; $i < 10; $i++) {
            $cancionEnDia1 = $this->entityManager->getRepository(CancionesDia1::class)->findOneBy(['nombre' => $nombresDia1[$i]]);
            $cancionEnDia0 = $this->entityManager->getRepository(Canciones::class)->findOneBy(['nombre' => $nombresDia1[$i]]);
            if ($cancionEnDia0 != null) {
                if ($cancionEnDia1->getPuesto() > $cancionEnDia0->getPuesto()) {
                    array_push($resultados["up"], $cancionEnDia1);
                } elseif ($cancionEnDia1->getPuesto() < $cancionEnDia0->getPuesto()) {
                    array_push($resultados["down"], $cancionEnDia1);
                } else {
                    array_push($resultados["stay"], $cancionEnDia1);
                }
            } else {
                array_push($resultados["down"], $cancionEnDia1);
            }
        }
        return $resultados;
    }
    public function checkWeeklySongPosition(EntityManagerInterface $entityManager)
    {
        $algoritmoController = new AlgoritmoController($entityManager); // Asegúrate de haber obtenido $entityManager de alguna manera
        $allSongs = $algoritmoController->getSongs();
        $nombresDia0 = [];
        for ($i = 0; $i < 10; $i++) {  //Guarda los nombres de las 10 canciones a buscar
            $nombre = $allSongs[0][0][$i]->getNombre();
            array_push($nombresDia0, $nombre);
        }
        $nombresDia1 = []; //Guarda los nombres de las 10 canciones del día anterior
        for ($i = 0; $i < 10; $i++) {  //Guarda los nombres de las 10 canciones a buscar
            $nombre = $allSongs[1][0][$i]->getNombre();
            array_push($nombresDia1, $nombre);
        }
        $resultados = [
            "up" => [],
            "down" => [],
            "stay" => []
        ];

        for ($i = 0; $i < 10; $i++) {
            $cancionEnDia1 = $this->entityManager->getRepository(CancionesWeek::class)->findOneBy(['nombre' => $nombresDia1[$i]]);
            $cancionEnDia0 = $this->entityManager->getRepository(Canciones::class)->findOneBy(['nombre' => $nombresDia1[$i]]);
            if ($cancionEnDia0 != null) {
                if ($cancionEnDia1->getPuesto() > $cancionEnDia0->getPuesto()) {
                    array_push($resultados["up"], $cancionEnDia1);
                } elseif ($cancionEnDia1->getPuesto() < $cancionEnDia0->getPuesto()) {
                    array_push($resultados["down"], $cancionEnDia1);
                } else {
                    array_push($resultados["stay"], $cancionEnDia1);
                }
            } else {
                array_push($resultados["down"], $cancionEnDia1);
            }
        }
        return $resultados;
    }
    public function actualizarCreditos(EntityManagerInterface $entityManager)
    {
        $apuestasRepository = $entityManager->getRepository(Apuestas::class);
        $apuestas = $apuestasRepository->findAll();

        $resultados = $this->checkSongPosition($entityManager); // Suponiendo que checkSongPosition devuelve $resultados correctamente
        foreach ($apuestas as $apuesta) {
            if ($apuesta->getTipo() == 'daily') {

                $cancion = $apuesta->getcancionesIdcancion();
                $accion = null;
                foreach ($resultados as $move => $nombresCanciones) {
                    if (in_array($cancion->getNombre(), $nombresCanciones)) {
                        $accion = $move;
                        break;
                    }
                }
                if ($apuesta->getPrediccion() == $accion) {
                    $usuario = $apuesta->getUsuario();
                    $usuario->setCreditos($usuario->getCreditos() + $apuesta->getCantidad() * $apuesta->getCuota());
                }
                $entityManager->remove($apuesta);
            }
        }
        // Guarda los cambios en la base de datos
        $entityManager->flush();
        return new Response('Apuestas comprobadas correctamente');
    }
    public function actualizarCreditosWeekly(EntityManagerInterface $entityManager)
    {
        $apuestasRepository = $entityManager->getRepository(Apuestas::class);
        $apuestas = $apuestasRepository->findAll();

        $resultados = $this->checkWeeklySongPosition($entityManager); // Suponiendo que checkSongPosition devuelve $resultados correctamente
        foreach ($apuestas as $apuesta) {
            if ($apuesta->getTipo() == 'weekly') {


                $cancion = $apuesta->getcancionesIdcancion();
                $accion = null;
                foreach ($resultados as $move => $nombresCanciones) {
                    if (in_array($cancion->getNombre(), $nombresCanciones)) {
                        $accion = $move;
                        break;
                    }
                }
                if ($apuesta->getPrediccion() == $accion) {
                    $usuario = $apuesta->getUsuario();
                    $usuario->setCreditos($usuario->getCreditos() + $apuesta->getCantidad() * $apuesta->getCuota());
                }
                $entityManager->remove($apuesta);
            }
        }
        // Guarda los cambios en la base de datos
        $entityManager->flush();
        return new Response('Apuestas comprobadas correctamente');
    }
}
