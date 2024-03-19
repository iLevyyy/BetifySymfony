<?php

namespace App\Controller;

use App\Entity\Apuestas;
use App\Entity\Artistas;
use App\Entity\Canciones;
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
        $apuesta->setFechaFinal($apuesta->createFechaFinal());
        $apuesta->setArtistasIdartista($data['IdArtista']);
        $apuesta->setCancionesIdcancion($data['IdCancion']);

        $user = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['id']]);

        if ($apuesta->getCantidad() > $user->getCreditos()) {
            return $this->json(['mensaje' => 'No se pueden apostar mas creditos de los disponibles', 'success' => false], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($apuesta);
        $this->entityManager->flush();
        return $this->json(['mensaje' => 'Apuesta creada correctamente', 'success' => true], Response::HTTP_OK);
    }
}
