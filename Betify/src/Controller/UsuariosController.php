<?php


namespace App\Controller;

use App\Entity\Usuarios;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuariosController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/usuarios/listar', name: 'listar_usuarios', methods: ['GET'])]
    public function listarUsuarios(): JsonResponse
    {
        // Obtén todos los usuarios desde el repositorio de la entidad Usuarios.
        $usuarios = $this->entityManager->getRepository(Usuarios::class)->findAll();

        // Prepara un array para almacenar los datos de los usuarios.
        $usuariosData = [];

        // Itera sobre cada usuario y obtén sus características.
        foreach ($usuarios as $usuario) {
            $usuariosData[] = [
                'nombre_usuario' => $usuario->getNombreUsuario(),
                'correo' => $usuario->getCorreo(),
                'password' => $usuario->getPassword(),
                // Puedes agregar más campos según sea necesario.
            ];
        }
 
        // Retorna los datos de los usuarios en formato JSON.
        return $this->json(['usuarios' => $usuariosData], Response::HTTP_OK);
    }


    #[Route('/usuarios/crear', name: 'crear_usuario', methods: ['POST'])]
    public function crearUsuario(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuario = new Usuarios();

        $usuario->setNombreUsuario($data['NombreUsuario']);
        $usuario->setPassword($data['Password']); 
        $usuario->setCorreo($data['Email']);

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return $this->json(['mensaje' => 'Usuario creado correctamente'], Response::HTTP_OK);
    }

    #[Route('/usuarios/update', name: 'actualizar_usuario', methods: ['PUT'])]
    public function actualizarUsuario(Request $request): JsonResponse
    {
        // Decodifica el contenido JSON de la solicitud y lo convierte en un array asociativo.
        $data = json_decode($request->getContent(), true);

        // Verifica si la ID está presente en el JSON.
        if (!isset($data['id'])) {
            return $this->json(['error' => 'ID del usuario no proporcionada'], Response::HTTP_BAD_REQUEST);
        }

        // Obtén el ID del usuario y el usuario que deseas actualizar desde el repositorio.
        $id = $data['id'];
        $usuario = $this->entityManager->getRepository(Usuarios::class)->find($id);

        // Verifica si el usuario existe.
        if (!$usuario) {
            return $this->json(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        // Actualiza los campos del usuario según los datos proporcionados.
        $usuario->setNombreUsuario($data['nombre_usuario'] ?? $usuario->getNombreUsuario());
        $usuario->setPassword($data['password'] ?? $usuario->getPassword());
        $usuario->setCorreo($data['correo'] ?? $usuario->getCorreo());

        // Persiste los cambios en la base de datos.
        $this->entityManager->flush();

        // Retorna una respuesta JSON indicando que el usuario se actualizó correctamente.
        return $this->json(['mensaje' => 'Usuario actualizado correctamente'], Response::HTTP_OK);
    }
    
    #[Route('/usuarios/delete/{id}', name: 'eliminar_usuario', methods: ['DELETE'])]
    public function eliminarUsuario(int $id): JsonResponse
    {
        // Obtén el usuario que deseas eliminar desde el repositorio.
        $usuario = $this->entityManager->getRepository(Usuarios::class)->find($id);

        // Verifica si el usuario existe.
        if (!$usuario) {
            return $this->json(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        // Elimina el usuario de la base de datos.
        $this->entityManager->remove($usuario);
        $this->entityManager->flush();

        // Retorna una respuesta JSON indicando que el usuario se eliminó correctamente.
        return $this->json(['mensaje' => 'Usuario eliminado correctamente'], Response::HTTP_OK);
    }
}
