<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CancionesDia1
 *
 * @ORM\Table(name="cancionesdia1", uniqueConstraints={@ORM\UniqueConstraint(name="idCancion_UNIQUE", columns={"idCancion"})})
 * @ORM\Entity
 */
class CancionesDia1
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCancion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcancion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nombre", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $nombre = 'NULL';

    /**
     * @var int|null
     *
     * @ORM\Column(name="Reproducciones", type="integer", nullable=true)
     */
    private $reproducciones;

    /**
     * @var int
     *
     * @ORM\Column(name="Puesto", type="integer", nullable=true)
     */
    private $puesto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Artista", type="string", length=90, nullable=true, options={"default"="NULL"})
     */
    private $artista = 'NULL';



    /**
     * Obtener el valor de idcancion
     *
     * @return int
     */
    public function getIdCancion(): int
    {
        return $this->idcancion;
    }
    /**
     * Obtener el valor de idcancion
     *
     * @return int
     */
    public function getArtista(): string
    {
        return $this->artista;
    }
    /**
     * Obtener el valor de nombre
     *
     * @return string|null
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * Establecer el valor de nombre
     *
     * @param string|null $nombre
     */
    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }
    public function setArtista(?string $artista): void
    {
        $this->artista = $artista;
    }
    public function getReproducciones(): ?int
    {
        return $this->reproducciones;
    }

    public function setReproducciones(int $reproducciones): self
    {
        $this->reproducciones = $reproducciones;

        return $this;
    }

    public function getPuesto(): ?int
    {
        return $this->puesto;
    }

    public function setPuesto(int $puesto): self
    {
        $this->puesto = $puesto;

        return $this;
    }
}
