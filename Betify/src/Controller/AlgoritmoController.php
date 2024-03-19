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


        $output = "Canciones del día 0:<br>";
        foreach ($cancionesDia0 as $cancion) {
            $output .= $cancion . "<br>";
        }

        $output .= "Canciones del día 1:<br>";
        foreach ($cancionesDia1 as $cancion) {
            $output .= $cancion . "<br>";
        }

        $output .= "Canciones del día 2:<br>";
        foreach ($cancionesDia2 as $cancion) {
            $output .= $cancion . "<br>";
        }

        $output .= "Canciones del día 3:<br>";
        foreach ($cancionesDia3 as $cancion) {
            $output .= $cancion . "<br>";
        }

        // Crear un objeto Response con la cadena como contenido
        $response = new Response($output);

        // Retornar el objeto Response
        return $response;
    }
}
