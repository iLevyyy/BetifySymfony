<?php

namespace App\Controller;


use App\Entity\Usuarios;
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

class UsuariosController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loginUsuarios(Request $request): JsonResponse
    {
        $user = json_decode($request->getContent(), true);

        $email = $user['Email'];
        $password = $user['Password'];

        $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['email' => $email, 'password' => $password]);

        if ($usuario != null) {
            $id = $usuario->getIdUsuario();
            return $this->json(['boolean'=> true,'token'=>$id, 'creditos' => $usuario->getCreditos(),], Response::HTTP_OK);
        } else {
            return $this->json(['boolean'=> false], Response::HTTP_OK);
        }
    }

    public function crearUsuario(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuario = new Usuarios();

        $usuario->setNombreUsuario($data['NombreUsuario']);
        $usuario->setPassword($data['Password']);
        $usuario->setEmail($data['Email']);

        if ($this->entityManager->getRepository(Usuarios::class)->findOneBy(['email' => $usuario->getEmail()])) {
            return $this->json(['Error al regitrar' => 'El correo electronico ya existe', 'boolean'=> false], Response::HTTP_OK);
        }
        if ($this->entityManager->getRepository(Usuarios::class)->findOneBy(['nombreusuario' => $usuario->getNombreUsuario()])) {
            return $this->json(['Error al regitrar' => 'El nombre de usuario ya existe', 'boolean'=> false], Response::HTTP_OK);
        }
        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return $this->json(['mensaje' => 'Usuario creado correctamente', 'boolean'=> true], Response::HTTP_OK);
    }


    public function actualizarUsuario(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $usuario = new Usuarios();

        $usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['email' => $data['Email']]);

        if (!$usuario) {
            return $this->json(['Error' => 'Usuario no encontrado', 'boolean' => false], Response::HTTP_NOT_FOUND);
        }

        if (!$data["newNombreUsuario"] == '') {
            $usuario->setNombreUsuario($data['newNombreUsuario']);
        }
        if (!trim($data["newPassword"]) == '') {
            $usuario->setPassword($data['newPassword']);
        }
        if (!trim($data["newEmail"]) == '') {
            $usuario->setEmail($data['newEmail']);
        }

        $this->entityManager->flush();

        return $this->json(['mensaje' => 'Usuario actualizado correctamente', 'boolean' => true], Response::HTTP_OK);
    }

    public function borrarUsuario(Request $request, ManagerRegistry $managerRegistry): JsonResponse
    {
        return $this->render('usuarios/borrar.html.twig');
    }
}
