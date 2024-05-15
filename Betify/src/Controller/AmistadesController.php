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
        if ($emisor->getIdUsuario() == $receptor->getIdUsuario()) {
            return $this->json(['mensaje' => 'No te puedes agregar a ti mismo', 'success' => false,], Response::HTTP_OK);
        }

        $existingFriend =  $this->entityManager->getRepository(Amistades::class)->findOneBy(['usuario1' => $emisor->getIdUsuario(), 'usuario2' => $receptor->getIdUsuario()]);
        $existingFriend2 =  $this->entityManager->getRepository(Amistades::class)->findOneBy(['usuario2' => $emisor->getIdUsuario(), 'usuario1' => $receptor->getIdUsuario()]);
        if ($existingFriend || $existingFriend2) {
            return $this->json(['mensaje' => 'Ya eres amigo de este usuario', 'success' => false,], Response::HTTP_OK);
        }
        $existingPetition = $this->entityManager->getRepository(Solicitud::class)->findOneBy(['remitente' => $emisor->getIdUsuario(), 'receptor' => $receptor->getIdUsuario()]);
        if ($existingPetition) {
            return $this->json(['mensaje' => 'Ya hay una peticion pendiente a este usuario', 'success' => false,], Response::HTTP_OK);
        }

        $solicitud = new Solicitud();
        $solicitud->setRemitente($emisor);
        $solicitud->setReceptor($receptor);
        $solicitud->setEstado('pendiente');

        $this->entityManager->persist($solicitud);
        $this->entityManager->flush();

        $petitions = $this->getUserPetitionsNames($data['token']);
        $amistades = $this->getUserFriendsNames($data['token']);
        return $this->json(['mensaje' => 'Solicitud de amistad enviada con exito', 'success' => true, 'amigosnombres' => $amistades, 'solicitudesnombres' => $petitions,], Response::HTTP_OK);
    }

    public function gestionarSolicitud(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $accion = $data['accion'];
        $receptor = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['token']]);
        $emisor = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['nombreusuario' => $data['nombre']]);

        if (!$emisor) {
            return $this->json(['mensaje' => 'Usuario no encontrado', 'success' => false,], Response::HTTP_OK);
        }
        if (!$receptor) {
            return $this->json(['mensaje' => 'Error al gestionar el token', 'success' => false,], Response::HTTP_OK);
        }
        $solicitud = $this->entityManager->getRepository(Solicitud::class)->findOneBy(['remitente' => $emisor->getIdUsuario(), 'receptor' => $receptor->getIdUsuario()]);
        if ($solicitud == null) {
            return $this->json(['mensaje' => 'Error al gestionar la solicitud', 'success' => false,], Response::HTTP_OK);
        }
        $this->entityManager->remove($solicitud);
        $this->entityManager->flush();
        if ($accion != null) {
            if ($accion == 'aceptar') {
                $amistad = new Amistades($receptor, $emisor);
                $solicitudRepetida = $this->entityManager->getRepository(Solicitud::class)->findOneBy(['remitente' => $receptor->getIdUsuario(), 'receptor' => $emisor->getIdUsuario()]);
                if ($solicitudRepetida) {
                    $this->entityManager->remove($solicitudRepetida);
                }
                $this->entityManager->persist($amistad);
                $this->entityManager->flush();
                return $this->json(['mensaje' => 'Solicitud de amistad aceptada con exito', 'success' => true,], Response::HTTP_OK);
            } else {
                return $this->json(['mensaje' => 'Solicitud de amistad rechazada con exito', 'success' => true,], Response::HTTP_OK);
            }
        } else {
            return $this->json(['mensaje' => 'No se ha indicado qué hacer con la solicitud', 'success' => false,], Response::HTTP_OK);
        }
    }
    public function borrarAmistad($token, $nombre)
    {
        $userToken = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $token]);
        $userNombre = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['nombreusuario' => $nombre]);

        $posibleAmistad1 =  $this->entityManager->getRepository(Amistades::class)->findOneBy(['usuario1' => $userToken->getIdUsuario(), 'usuario2' => $userNombre->getIdUsuario()]);
        $posibleAmistad2 =  $this->entityManager->getRepository(Amistades::class)->findOneBy(['usuario2' => $userToken->getIdUsuario(), 'usuario1' => $userNombre->getIdUsuario()]);
        if(!$posibleAmistad1 && !$posibleAmistad2){
            return $this->json(['mensaje' => 'No se ha encontrado la amistad', 'success' => false,], Response::HTTP_OK);
        }
        if ($posibleAmistad1) {
            $this->entityManager->remove($posibleAmistad1);
        } elseif ($posibleAmistad2) {
            $this->entityManager->remove($posibleAmistad2);
        }
        $this->entityManager->flush();
        return $this->json(['mensaje' => 'Amigo eliminado correctamente', 'success' => true,], Response::HTTP_OK);
    }
    public function callBorrarAmistad(Request $request){
        $data = json_decode($request->getContent(), true);
        $token = $data['token'];
        $nombre = $data['nombre'];
        return $this->borrarAmistad($token,$nombre);
    }
    public function getUserPetitions($token)
    {
        $peticionesPrimeraColumna = $this->entityManager->getRepository(Solicitud::class)->findBy(['receptor' => $token]);
        return $peticionesPrimeraColumna;
    }
    public function getUserPetitionsNames($token)
    {
        $peticionesPrimeraColumna = $this->entityManager->getRepository(Solicitud::class)->findBy(['receptor' => $token]);
        $nombres = [];
        foreach ($peticionesPrimeraColumna as $peticion) {
            array_push($nombres, $peticion->getRemitente()->getNombreUsuario());
        }
        return $nombres;
    }
    public function getUserFriends($token)
    {
        $amistadesPrimeraColumna = $this->entityManager->getRepository(Amistades::class)->findBy(['usuario1' => $token]);
        $amistadesSegundaColumna = $this->entityManager->getRepository(Amistades::class)->findBy(['usuario2' => $token]);
        $amistades = array_merge($amistadesPrimeraColumna, $amistadesSegundaColumna);
        return $amistades;
    }
    public function getUserFriendsNames($token)
    {
        $amistadesPrimeraColumna = $this->entityManager->getRepository(Amistades::class)->findBy(['usuario1' => $token]);
        $amistadesSegundaColumna = $this->entityManager->getRepository(Amistades::class)->findBy(['usuario2' => $token]);
        $amistades = array_merge($amistadesPrimeraColumna, $amistadesSegundaColumna);
        $nombres = [];
        foreach ($amistades as $amistad) {
            if ($amistad->getUsuario1()->getIdUsuario() != $token) {
                array_push($nombres, $amistad->getUsuario1()->getNombreUsuario());
            } elseif ($amistad->getUsuario2()->getIdUsuario() != $token) {
                array_push($nombres, $amistad->getUsuario2()->getNombreUsuario());
            }
        }
        return $nombres;
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
    public function sendUserFriendList(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $token = $data['token'];
        $nombres = $this->getUserFriendsNames($token);
        return $this->json(['nombres' => $nombres, 'success' => true,], Response::HTTP_OK);
    }
}
