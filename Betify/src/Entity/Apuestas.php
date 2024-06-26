<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Apuestas
 *
 * @ORM\Table(name="apuestas", indexes={@ORM\Index(name="fk_Apuestas_Canciones1_idx", columns={"Canciones_idCancion"})})
 * @ORM\Entity
 */
class Apuestas
{
    /**
     * @var int
     *
     * @ORM\Column(name="idApuesta", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @var string|null
     *
     * @ORM\Column(name="Prediccion", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $prediccion = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Tipo", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $tipo = 'NULL';


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FechaFinal", type="datetime", nullable=false)
     */
    private $fechafinal;

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
     * @var \Usuarios
     *
     * @ORM\ManyToOne(targetEntity="Usuarios", inversedBy="apuestas")
     * @ORM\JoinColumn(name="Usuarios_idUsuario", referencedColumnName="idUsuario")
     */
    private $usuario;

    /**
     * Obtener el usuario asociado a esta apuesta.
     *
     * @return \Usuarios
     */
    public function getUsuario(): ?Usuarios
    {
        return $this->usuario;
    }

    /**
     * Establecer el usuario asociado a esta apuesta.
     *
     * @param \Usuarios|null $usuario
     */
    public function setUsuario(?Usuarios $usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * Obtener el valor de idapuesta
     *
     * @return int
     */
    public function getIdApuesta(): int
    {
        return $this->idapuesta;
    }
    public function getTipo(): string|null
    {
        return $this->tipo;
    }
    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
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
     * Obtener el valor de prediccion
     *
     * @return string
     */
    public function getPrediccion(): string
    {
        return $this->prediccion;
    }
    /**
     * Establecer el valor de prediccion
     *
     * @param string $cantidad
     */
    public function setPrediccion(string $prediccion): void
    {
        $this->prediccion = $prediccion;
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

    public function createFechaFinal()
    {
        // Obtener la fecha y hora actual
        $fechaActual = new DateTime();

        // Añadir un día
        $fechaActual->modify('+1 day');

        // Establecer la hora a las 17:10:00
        $fechaActual->setTime(17, 10, 00);
        return $fechaActual;
    }
}
