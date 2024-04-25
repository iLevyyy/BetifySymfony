<?php

namespace App\Controller;

use App\Entity\Amistades;
use App\Entity\Solicitud;
use App\Entity\Usuarios;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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

        if (!$emisor) {
            return $this->json(['mensaje' => 'Error al gestionar el token', 'success' => false,], Response::HTTP_OK);
        }
        if (!$receptor) {
            return $this->json(['mensaje' => 'Usuario no encontrado', 'success' => false,], Response::HTTP_OK);
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

        if (!$emisor) {
            return $this->json(['mensaje' => 'Error al gestionar el token', 'success' => false,], Response::HTTP_OK);
        }
        if (!$receptor) {
            return $this->json(['mensaje' => 'Usuario no encontrado', 'success' => false,], Response::HTTP_OK);
        }


        if ($accion == 'aceptar') {
            $amistad = new Amistades($emisor, $receptor);
            $this->entityManager->persist($amistad);
        }
        $solicitud = $this->entityManager->getRepository(Solicitud::class)->findOneBy(['remitente' => $emisor, 'receptor' => $receptor]);
        $this->entityManager->remove($solicitud);
        $this->entityManager->flush();

        return $this->json(['mensaje' => 'Solicitud de amistad gestionada con exito', 'success' => true,], Response::HTTP_OK);
    }
    public function getUserPetitions($token)
    {
        $peticionesPrimeraColumna = $this->entityManager->getRepository(Solicitud::class)->findBy(['receptor' => $token]);
        return $peticionesPrimeraColumna;
    }

    public function sendUserPetitionsNames(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $token = $data['token'];
        $peticiones = $this->getUserPetitions($token);
        $nombres = [];
        foreach ($peticiones as $peticion) {
            array_push($nombres, $peticion->getRemitente()->getNombreUsuario());
        }
        return $this->json(['nombres' => $nombres, 'success' => true,], Response::HTTP_OK);
    }
}
