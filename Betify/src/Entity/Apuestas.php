<?php

namespace App\Entity;
// require_once __DIR__ . '../../vendor/autoload.php';
require_once __DIR__ . '../../vendor/autoload.php';


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Http\Authentication\CustomAuthenticationSuccessHandler;

/**
 * Apuestas
 *
 * @ORM\Table(name="apuestas", indexes={@ORM\Index(name="fk_Apuestas_Artistas1_idx", columns={"Artistas_idArtista"}), @ORM\Index(name="fk_Apuestas_Canciones1_idx", columns={"Canciones_idCancion"})})
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
     * @var float|null
     *
     * @ORM\Column(name="Cuota", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $cuota = NULL;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Cantidad", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $cantidad = NULL;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="FechaFinal", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $fechafinal = 'NULL';

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
     * @var \Artistas
     *
     * @ORM\ManyToOne(targetEntity="Artistas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Artistas_idArtista", referencedColumnName="idArtista")
     * })
     */
    private $artistasIdartista;

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

    public function getIdapuesta(): ?int
    {
        return $this->idapuesta;
    }

    public function getCuota(): ?float
    {
        return $this->cuota;
    }

    public function setCuota(?float $cuota): static
    {
        $this->cuota = $cuota;

        return $this;
    }

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(?float $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getFechafinal(): ?\DateTimeInterface
    {
        return $this->fechafinal;
    }

    public function setFechafinal(?\DateTimeInterface $fechafinal): static
    {
        $this->fechafinal = $fechafinal;

        return $this;
    }

    public function getCancionesIdcancion(): ?Canciones
    {
        return $this->cancionesIdcancion;
    }

    public function setCancionesIdcancion(?Canciones $cancionesIdcancion): static
    {
        $this->cancionesIdcancion = $cancionesIdcancion;

        return $this;
    }

    public function getArtistasIdartista(): ?Artistas
    {
        return $this->artistasIdartista;
    }

    public function setArtistasIdartista(?Artistas $artistasIdartista): static
    {
        $this->artistasIdartista = $artistasIdartista;

        return $this;
    }

    /**
     * @return Collection<int, Usuarios>
     */
    public function getUsuariosIdusuario(): Collection
    {
        return $this->usuariosIdusuario;
    }

    public function addUsuariosIdusuario(Usuarios $usuariosIdusuario): static
    {
        if (!$this->usuariosIdusuario->contains($usuariosIdusuario)) {
            $this->usuariosIdusuario->add($usuariosIdusuario);
            $usuariosIdusuario->addApuestasIdapuestum($this);
        }

        return $this;
    }

    public function removeUsuariosIdusuario(Usuarios $usuariosIdusuario): static
    {
        if ($this->usuariosIdusuario->removeElement($usuariosIdusuario)) {
            $usuariosIdusuario->removeApuestasIdapuestum($this);
        }

        return $this;
    }

}
