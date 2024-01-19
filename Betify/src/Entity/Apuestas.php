<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Apuestas
 *
 * @ORM\Table(name="apuestas", indexes={@ORM\Index(name="fk_Apuestas_Canciones1_idx", columns={"Canciones_idCancion"}), @ORM\Index(name="fk_Apuestas_Artistas1_idx", columns={"Artistas_idArtista"})})
 * @ORM\Entity
 */
class Apuestas
{
    /**
     * @var int
     *
     * @ORM\Column(name="idApuesta", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idapuesta;

    /**
     * @var float
     *
     * @ORM\Column(name="Cuota", type="float", precision=10, scale=0, nullable=false)
     */
    private $cuota;

    /**
     * @var float
     *
     * @ORM\Column(name="Cantidad", type="float", precision=10, scale=0, nullable=false)
     */
    private $cantidad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FechaFinal", type="datetime", nullable=false)
     */
    private $fechafinal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Canciones_idCancion", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $cancionesIdcancion = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Artistas_idArtista", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $artistasIdartista = NULL;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usuarios", mappedBy="apuestasIdapuesta")
     */
    private $usuariosIdusuario = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuariosIdusuario = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
