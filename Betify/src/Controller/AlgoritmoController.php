<?php

namespace App\Controller;

use App\Entity\Apuestas;
use App\Entity\Artistas;
use App\Entity\Canciones;
use App\Entity\CancionesDia1;
use App\Entity\CancionesDia2;
use App\Entity\CancionesDia3;
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
use Symfony\Component\Validator\Constraints\Length;

class AlgoritmoController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getSongs()
    {
        $cancionesDia0 = $this->entityManager->getRepository(Canciones::class)->findAll();
        $cancionesDia1 = $this->entityManager->getRepository(CancionesDia1::class)->findAll();
        $cancionesDia2 = $this->entityManager->getRepository(CancionesDia2::class)->findAll();
        $cancionesDia3 = $this->entityManager->getRepository(CancionesDia3::class)->findAll();

        $allSongs = [];
        $allSongs[0] = [$cancionesDia0];
        $allSongs[1] = [$cancionesDia1];
        $allSongs[2] = [$cancionesDia2];
        $allSongs[3] = [$cancionesDia3];

        return($allSongs);
    }

    public function calcularCuota(EntityManagerInterface $entityManager){
        $algoritmoController = new AlgoritmoController($entityManager); // Asegúrate de haber obtenido $entityManager de alguna manera
        $allSongs = $algoritmoController->getSongs(); 
        $nombresDia0 = [];
        for ($i=0; $i < 10 ; $i++) {  //Guarda los nombres de las 10 canciones a buscar
           $nombre = $allSongs[0][0][$i]->getNombre();
           array_push($nombresDia0,$nombre);
        }
        for ($i=0; $i < sizeof($allSongs) ; $i++) { 
            $allSongs[$i][0];

        }
        for ($i=0; $i <10 ; $i++) { 
            if($nombresDia0[$i]);
        }
    }
}
