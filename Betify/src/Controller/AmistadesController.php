<?php

namespace App\Controller;

use App\Entity\Amistades;
use App\Entity\Apuestas;
use App\Entity\Artistas;
use App\Entity\Canciones;
use App\Entity\CancionesDia1;
use App\Entity\CancionesDia2;
use App\Entity\CancionesDia3;
use App\Entity\CancionesWeek;
use App\Entity\Solicitud;
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

class AmistadesController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function crearSolicitud(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $emisor = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['token']]);
        $receptor = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['nombreusuario' => $data['nombre']]);

        if (!$emisor || !$receptor) {
            return $this->json(['mensaje' => 'Ha ocurrido un problema al enviar la solicitud', 'success' => false,], Response::HTTP_OK);
        }
        $solicitud = new Solicitud();
        $solicitud->setRemitente($emisor);
        $solicitud->setReceptor($receptor);
        $solicitud->setEstado('pendiente');

        $this->entityManager->persist($solicitud);
        $this->entityManager->flush();
        return $this->json(['mensaje' => 'Solicitud de amistad enviada con exito', 'success' => true,], Response::HTTP_OK);
    }

    public function gestionarSolicitud(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $accion = $data['accion'];
        $receptor = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['token']]);
        $emisor = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['nombreusuario' => $data['nombre']]);

        if (!$emisor || !$receptor) {
            return $this->json(['mensaje' => 'Ha ocurrido un problema al enviar la solicitud', 'success' => false,], Response::HTTP_OK);
        }

        if($accion == 'aceptar'){
            $amistad = new Amistades($emisor,$receptor);
            $this->entityManager->persist($amistad);
        }
        $solicitud = $this->entityManager->getRepository(Solicitud::class)->findOneBy(['remitente' => $emisor,'receptor' => $receptor]);
        $this->entityManager->remove($solicitud);

        return $this->json(['mensaje' => 'Solicitud de amistad gestionada con exito', 'success' => true,], Response::HTTP_OK);
    }
}
