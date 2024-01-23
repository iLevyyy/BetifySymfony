<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Artistas
 *
 * @ORM\Table(name="artistas", uniqueConstraints={@ORM\UniqueConstraint(name="Nombre_UNIQUE", columns={"Nombre"})})
 * @ORM\Entity
 */
class Artistas
{
    /**
     * @var int
     *
     * @ORM\Column(name="idArtista", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idartista;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nombre", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $nombre = 'NULL';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Canciones", mappedBy="artistasIdartista")
     */
    private $cancionesIdcancion = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cancionesIdcancion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdartista(): ?int
    {
        return $this->idartista;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Canciones>
     */
    public function getCancionesIdcancion(): Collection
    {
        return $this->cancionesIdcancion;
    }

    public function addCancionesIdcancion(Canciones $cancionesIdcancion): static
    {
        if (!$this->cancionesIdcancion->contains($cancionesIdcancion)) {
            $this->cancionesIdcancion->add($cancionesIdcancion);
            $cancionesIdcancion->addArtistasIdartistum($this);
        }

        return $this;
    }

    public function removeCancionesIdcancion(Canciones $cancionesIdcancion): static
    {
        if ($this->cancionesIdcancion->removeElement($cancionesIdcancion)) {
            $cancionesIdcancion->removeArtistasIdartistum($this);
        }

        return $this;
    }

}
