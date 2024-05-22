<?php

namespace App\Controller;


use App\Entity\Usuarios;
use App\Entity\Amistades;
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
use App\Controller\AmistadesController;

class UsuariosController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUsersNames()
    {
        $usuarios = $this->entityManager->getRepository(Usuarios::class)->findAll();
        $nombres = [];
        foreach ($usuarios as $key => $usuario) {
            array_push($nombres, $usuario->getNombreUsuario());
        }
        return $nombres;
    }
    public function getUsersPrivileges()
    {
        $usuarios = $this->entityManager->getRepository(Usuarios::class)->findAll();
        $privileges = [];
        foreach ($usuarios as $key => $usuario) {
            array_push($privileges, $usuario->isAdmin());
        }
        return $privileges;
    }

    public function getUsersInfo()
    {
        $data = [];
        $userNames = $this->getUsersNames();
        $userPrivileges = $this->getUsersPrivileges();

        foreach ($userNames as $index => $name) {
            $data[$name] = $userPrivileges[$index];
        }

        return $this->json(['success' => true, 'data' => $data], Response::HTTP_OK);
    }
    public function loginUsuarios(Request $request): JsonResponse
    {
        $user = json_decode($request->getContent(), true);

        $email = $user['Email'];
        $password = $user['Password'];

        $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['email' => $email, 'password' => $password]);

        if ($usuario != null) {
            $id = $usuario->getIdUsuario();
            $solicitudesNombres = (new AmistadesController($this->entityManager))->getUserPetitionsNames($usuario->getIdUsuario());
            $amistadesNombres = (new AmistadesController($this->entityManager))->getUserFriendsNames($usuario->getIdUsuario());
            return $this->json(['boolean' => true, 'token' => $id, 'creditos' => $usuario->getCreditos(), 'solicitudesnombres' => $solicitudesNombres, 'amistadesnombres' => $amistadesNombres, 'nombreUsuario' => $usuario->getNombreUsuario(), 'emailUsuario' => $usuario->getEmail()], Response::HTTP_OK);
        } else {
            return $this->json(['boolean' => false, 'message' => 'Correo o contraseña incorrectos'], Response::HTTP_OK);
        }
    }

    public function getCreditos(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['token']]);
        return $this->json(['boolean' => true, 'message' => 'creditos enviados', 'creditos' => $usuario->getCreditos()], Response::HTTP_OK);
    }
    public function crearUsuario(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuario = new Usuarios();

        $usuario->setNombreUsuario($data['NombreUsuario']);
        $usuario->setPassword($data['Password']);
        $usuario->setEmail($data['Email']);
        $usuario->setCreditos(150);

        if ($this->entityManager->getRepository(Usuarios::class)->findOneBy(['email' => $usuario->getEmail()])) {
            return $this->json(['Error al regitrar' => 'El correo electronico ya existe', 'boolean' => false], Response::HTTP_OK);
        }
        if ($this->entityManager->getRepository(Usuarios::class)->findOneBy(['nombreusuario' => $usuario->getNombreUsuario()])) {
            return $this->json(['Error al regitrar' => 'El nombre de usuario ya existe', 'boolean' => false], Response::HTTP_OK);
        }
        $this->entityManager->persist($usuario);
        $this->entityManager->flush();


        return $this->json(['mensaje' => 'Usuario creado correctamente', 'boolean' => true,], Response::HTTP_OK);
    }


    public function actualizarUsuario(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $newEmail = trim($data['newEmail']);
        $newNombre = trim($data['newNombreUsuario']);
        $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['token']]);

        if (!$usuario) {
            return $this->json(['Error' => 'Usuario no encontrado', 'boolean' => false], Response::HTTP_NOT_FOUND);
        }

        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('u.nombreusuario') // Seleccionar solo el campo 'nombre' de la entidad 'Usuarios'
            ->from(Usuarios::class, 'u'); // Definir la entidad y el alias

        $nombresUsuarios = $queryBuilder->getQuery()->getResult();
        foreach ($nombresUsuarios as $key => $nombre) {
            if ($nombre == $newNombre) {
                return $this->json(['mensaje' => 'El nombre de usuario no está disponible', 'success' => false], Response::HTTP_OK);
            }
        }
        if (!$data["newNombreUsuario"] == '') {
            $usuario->setNombreUsuario($newNombre);
        }

        if (!trim($data["newPassword"]) == '') {
            $usuario->setPassword($data['newPassword']);
        }

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('u.email') // Seleccionar solo el campo 'nombre' de la entidad 'Usuarios'
            ->from(Usuarios::class, 'u'); // Definir la entidad y el alias
        $correos = $queryBuilder->getQuery()->getResult();

        foreach ($correos as $key => $correo) {
            if ($correo == $newEmail) {
                return $this->json(['mensaje' => 'El correo ya esta en uso', 'success' => false], Response::HTTP_OK);
            }
        }
        if (!trim($data["newEmail"]) == '') {
            $usuario->setEmail($newEmail);
        }

        $this->entityManager->flush();

        return $this->json(['mensaje' => 'Usuario actualizado correctamente', 'boolean' => true], Response::HTTP_OK);
    }

    public function borrarUsuario(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $AmistadesController = new AmistadesController($this->entityManager);

        $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['nombreusuario' => $data['nombreUsuario']]);
        if (!$usuario) {
            return $this->json(['mensaje' => 'Usuario no encontrado', 'success' => false], Response::HTTP_OK);
        }

        $amistades = $AmistadesController->getUserFriends($usuario->getIdUsuario());
        foreach ($amistades as $key => $amistad) {
            $this->entityManager->remove($amistad);
        }
        $solicitudes = $AmistadesController->getUserPetitions($usuario->getIdUsuario());
        foreach ($solicitudes as $key => $solicitud) {
            $this->entityManager->remove($solicitud);
        }
        $this->entityManager->remove($usuario);
        $this->entityManager->flush();

        return $this->json(['mensaje' => 'Usuario eliminado correctamente', 'success' => true], Response::HTTP_OK);
    }

    public function crearAmistad(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $usuario1 = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['idUsuario1']]);
        $usuario2 = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['idUsuario2']]);

        if (!$usuario1 || !$usuario2) {
            return $this->json(['mensaje' => 'Ha habido un error a la hora de crear la amistad', 'success' => false], Response::HTTP_OK);
        }
        // Crear una nueva instancia de la entidad Amistad
        $nuevaAmistad = new Amistades($usuario1, $usuario2);

        // Agregar la nueva amistad al EntityManager
        $this->entityManager->persist($nuevaAmistad);

        // Aplicar los cambios a la base de datos
        $this->entityManager->flush();

        return $this->json(['mensaje' => 'Amistad creada correctamente entre ' . $usuario1->getNombreUsuario() . ' y ' . $usuario2->getNombreUsuario(), 'success' => true], Response::HTTP_OK);
    }
    public function checkAdmin(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['idusuario' => $data['token']]);
        if ($usuario->isAdmin()) {
            return $this->json(['success' => true], Response::HTTP_OK);
        } else {
            return $this->json(['success' => false, 'mensaje' => 'Contenido restringido'], Response::HTTP_OK);
        }
    }
}
