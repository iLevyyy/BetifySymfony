<?php

namespace App\Controller;

use App\Entity\Apuestas;
use App\Entity\Artistas;
use App\Entity\Canciones;
use App\Entity\CancionesDia1;
use App\Entity\CancionesDia2;
use App\Entity\CancionesDia3;
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

    public function crearApuestas(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Deserializar datos de la apuesta recibidos de Postman
        $datosApuesta = json_decode($request->getContent(), true);

        // Crear una instancia de la entidad Apuesta
        $apuesta = new Apuestas();
        $apuesta->setCuota($datosApuesta['cuota']);
        $apuesta->setCantidad($datosApuesta['cantidad']);
        $apuesta->setFechaFinal(new \DateTime());

        // Persistir la apuesta en la base de datos
        $entityManager->persist($apuesta);
        $entityManager->flush();

        // Obtener el usuario al que deseas asociar la apuesta (suponiendo que obtienes el usuario de la sesión)
        $usuario = $entityManager->getRepository(Usuarios::class)->find();

        // Asociar la apuesta al usuario
        $usuario->addApuesta($apuesta);

        // Persistir los cambios en el usuario
        $entityManager->persist($usuario);
        $entityManager->flush();

        return new JsonResponse(['mensaje' => 'Apuesta creada y asociada al usuario exitosamente']);
    }
    public function crearApuesta(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $apuesta = new Apuestas();

        $apuesta->setCuota($data['Cuota']);
        $apuesta->setCantidad($data['Cantidad']);
        $apuesta->setPrediccion($data['Prediccion']);
        $apuesta->setFechaFinal($apuesta->createFechaFinal());
        //$apuesta->setArtistasIdartista($data['IdArtista']);
        $cancion = $this->entityManager->getRepository(Canciones::class)->findOneBy(['nombre' => $data['Cancion']]);
        $apuesta->setCancionesIdcancion($cancion);


        $user = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['id']]);
        if ($apuesta->getCantidad() > $user->getCreditos()) {
            return $this->json(['mensaje' => 'No se pueden apostar mas creditos de los disponibles', 'success' => false], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($apuesta);
        $this->entityManager->flush();
        return $this->json(['mensaje' => 'Apuesta creada correctamente', 'success' => true], Response::HTTP_OK);
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

        dd($resultados);
    }
}
