<?php

namespace App\Controller;

use App\Entity\Canciones;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;

class CancionesController extends AbstractController
{
    public function listarCancion(ManagerRegistry $managerRegistry): JsonResponse
    {
        $Canciones = $managerRegistry->getRepository(Canciones::class)->findAll();

        $CancionesArray = [];
        foreach ($Canciones as $Cancion) {
            $CancionesArray[] = [  
                'IdProvincia' => $Cancion->getIdCancion(),
                'Nombre' => $Cancion->getNombre(),
            ];
        }

        return new JsonResponse($CancionesArray);
    }
}
