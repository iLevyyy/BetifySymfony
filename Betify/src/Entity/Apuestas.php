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
     * @var \Artistas
     *
     * @ORM\ManyToOne(targetEntity="Artistas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Artistas_idArtista", referencedColumnName="idArtista")
     * })
     */
    private $artistasIdartista;

    /**
     * @var \Canciones
     *
     * @ORM\ManyToOne(targetEntity="Canciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Canciones_idCancion", referencedColumnName="idCancion")
     * })
     */
    private $cancionesIdcancion;

    /**
     * Obtener el valor de idapuesta
     *
     * @return int
     */
    public function getIdApuesta(): int
    {
        return $this->idapuesta;
    }

    /**
     * Establecer el valor de idapuesta
     *
     * @param int $idapuesta
     */
    public function setIdApuesta(int $idapuesta): void
    {
        $this->idapuesta = $idapuesta;
    }

    /**
     * Obtener el valor de cuota
     *
     * @return float
     */
    public function getCuota(): float
    {
        return $this->cuota;
    }

    /**
     * Establecer el valor de cuota
     *
     * @param float $cuota
     */
    public function setCuota(float $cuota): void
    {
        $this->cuota = $cuota;
    }

    /**
     * Obtener el valor de cantidad
     *
     * @return float
     */
    public function getCantidad(): float
    {
        return $this->cantidad;
    }

    /**
     * Establecer el valor de cantidad
     *
     * @param float $cantidad
     */
    public function setCantidad(float $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * Obtener el valor de fechafinal
     *
     * @return \DateTime
     */
    public function getFechaFinal(): \DateTime
    {
        return $this->fechafinal;
    }

    /**
     * Establecer el valor de fechafinal
     *
     * @param \DateTime $fechafinal
     */
    public function setFechaFinal(\DateTime $fechafinal): void
    {
        $this->fechafinal = $fechafinal;
    }

    /**
     * Obtener el valor de artistasIdartista
     *
     * @return \Artistas
     */
    public function getArtistasIdartista(): ?Artistas
    {
        return $this->artistasIdartista;
    }

    /**
     * Establecer el valor de artistasIdartista
     *
     * @param \Artistas $artistasIdartista
     */
    public function setArtistasIdartista(?Artistas $artistasIdartista): void
    {
        $this->artistasIdartista = $artistasIdartista;
    }

    /**
     * Obtener el valor de cancionesIdcancion
     *
     * @return \Canciones
     */
    public function getcancionesIdcancion(): ?Canciones
    {
        return $this->cancionesIdcancion;
    }

    /**
     * Establecer el valor de cancionesIdcancion
     *
     * @param \Canciones $cancionesIdcancion
     */
    public function setCancionesIdcancion(?Canciones $cancionesIdcancion): void
    {
        $this->cancionesIdcancion = $cancionesIdcancion;
    }
}