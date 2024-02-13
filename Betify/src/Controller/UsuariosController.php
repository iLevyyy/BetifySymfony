<?php

namespace App\Controller;


use App\Entity\Apuestas;
use App\Entity\Usuarios;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UsuariosController extends AbstractController
{

    //login
    public function listarUsuarios(ManagerRegistry $managerRegistry): JsonResponse
    {
        $usuarios = $managerRegistry->getRepository(Usuarios::class)->findAll();
        // $apuestas = $managerRegistry->getRepository(Apuestas::class)->findAll();
        $usuariosArray = [];
        foreach ($usuarios as $usuario) {
            $usuariosArray[] = [
                'idusuario' => $usuario->getIdUsuario(),
                'nombreusuario' => $usuario->getNombreUsuario(),
                'email' => $usuario->getEmail(),
                'password' => $usuario->getPassword(),
            ];
        }

        return new JsonResponse($usuariosArray);
    }

    public function listarUsuariosId($email, ManagerRegistry $managerRegistry): JsonResponse
    {
        $usuario = $managerRegistry->getRepository(Usuarios::class)->find($email);

        if (!$usuario) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        $usuariosArray[] = [
            'idusuario' => $usuario->getIdUsuario(),
            'nombreusuario' => $usuario->getNombreUsuario(),
            'email' => $usuario->getEmail(),
            'password' => $usuario->getPassword(),
        ];

        return new JsonResponse($usuariosArray);
    }


    //registro
    public function nuevoUsuario(Request $request, ManagerRegistry $managerRegistry)
    {
        if ($request->isMethod('POST')) {
            $nombre = $request->request->get('nombre');
            $email = $request->request->get('email');
            $pwd = $request->request->get('pwd');

            $usuario = $this->createUsuario($managerRegistry, $nombre, $email, $pwd);

            $usuariosArray = [
                'id' => $usuario->getIdUsuario(),
                'nombre' => $usuario->getNombreUsuario(),
                'email' => $usuario->getEmail(),
                'pwd' => $usuario->getPassword(),
            ];

            return new JsonResponse($usuariosArray);
        }

        // Si no es una solicitud POST, simplemente renderiza la plantilla Twig
        return $this->render('usuarios/nuevo.html.twig');
    }

    private function createUsuario(ManagerRegistry $managerRegistry, $nombre, $email, $pwd): Usuarios
    {
        $usuario = new Usuarios();
        $usuario->setNombreUsuario($nombre);
        $usuario->setEmail($email);
        $usuario->setPassword($pwd);

        $entityManager = $managerRegistry->getManager();
        $entityManager->persist($usuario);
        $entityManager->flush();

        return $usuario;
    }

    //editar usuario
    public function formularioEditarUsuario(Request $request, ManagerRegistry $managerRegistry): JsonResponse
    {
        $usuarios = $managerRegistry->getRepository(Usuarios::class)->findAll();
    
        $choices = [];
        foreach ($usuarios as $usuario) {
            $choices[$usuario->getNombreUsuario()] = $usuario->getIdUsuario();
        }
    
        $form = $this->createFormBuilder()
            ->add('usuario', ChoiceType::class, [
                'label' => 'Selecciona un Usuario',
                'choices' => $choices,
            ])
            ->add('editar', SubmitType::class, ['label' => 'Editar Usuario'])
            ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $usuarioId = $data['usuario'];
    
            return $this->redirectToRoute('editar', ['id' => $usuarioId]);
        }
    
        return $this->render('usuarios/formuario_editar.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    public function editarUsuario($id, Request $request, ManagerRegistry $managerRegistry): JsonResponse
    {
        $usuario = $managerRegistry->getRepository(Usuarios::class)->find($id);

        if (!$usuario) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        $form = $this->createForm(Usuarios::class, $usuario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $managerRegistry->getManager();
            $entityManager->flush();

            $clienteArray = [
                'id' => $usuario->getIdUsuario(),
                'nombre' => $usuario->getNombreUsuario(),
                'email' => $usuario->getEmail(),
                'pwd' => $usuario->getPassword(),
            ];

            return new JsonResponse($clienteArray);
        }

        return $this->render('usuarios/editar.html.twig', [
            'form' => $form->createView(),
            'usuario' => $usuario,
        ]);
    }
    
    //borrar ususario
    public function borrarUsuario(Request $request, ManagerRegistry $managerRegistry): JsonResponse
    {
        $form = $this->createFormBuilder()
            ->add('id', IntegerType::class, [
                'label' => 'ID del Usuario',
                'attr' => ['placeholder' => 'Ingrese el ID del Usuario']
            ])
            ->add('borrar', SubmitType::class, ['label' => 'Borrar Usuario'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $idUsuario = $data['id'];
            $em = $managerRegistry->getManager();
            $usuario = $em->getRepository(Usuarios::class)->find($idUsuario);

            if (!$usuario) {
                throw $this->createNotFoundException('Cliente no encontrado');
            }

            $em->remove($usuario);
            $em->flush();

            return new JsonResponse(['mensaje' => 'Usuario eliminado con éxito']);
        }

        return $this->render('usuarios/borrar.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}
