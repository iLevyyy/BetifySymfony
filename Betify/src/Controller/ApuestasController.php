<?php

namespace App\Controller;

use App\Entity\Apuestas;
use App\Entity\Artistas;
use App\Entity\Canciones;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
class ApuestasController extends AbstractController
{
    public function listarApuestas(ManagerRegistry $managerRegistry): JsonResponse
    {
        $Apuestas = $managerRegistry->getRepository(Apuestas::class)->findAll();
        $Canciones = $managerRegistry->getRepository(Canciones::class)->findAll();
        //$Artistas;
        $Artistas = $managerRegistry->getRepository(Artistas::class)->findAll();
        // dd($Artistas)
        $ApuestasArray = [];
        foreach ($Apuestas as $Apuesta) {
            $ApuestasArray[] = [  
                'idapuesta' => $Apuesta->getIdApuesta(),
                'cuota' => $Apuesta->getCuota(),
                'cantidad' => $Apuesta->getCantidad(),
                'fechafinal' => $Apuesta->getFechaFinal(),
                'artistasIdartista' => $Artistas[0]->getNombre(),
                'cancionesIdcancion' => $Canciones,
            ];
            
        }

        return new JsonResponse($ApuestasArray);
    }
}
