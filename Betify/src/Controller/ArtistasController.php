<?php

namespace App\Controller;

use App\Entity\Artistas;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;

class ArtistasController extends AbstractController
{
    public function listarArtista(ManagerRegistry $managerRegistry): JsonResponse
    {
        $Artistas = $managerRegistry->getRepository(Artistas::class)->findAll();

        $ArtistasArray = [];
        foreach ($Artistas as $Artista) {
            $ArtistasArray[] = [  
                'IdArtista' => $Artista->getIdArtista(),
                'Nombre' => $Artista->getNombre(),
            ];
        }

        return new JsonResponse($ArtistasArray);
    }
}
