<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CancionesWeek
 *
 * @ORM\Table(name="CancionesWeek", uniqueConstraints={@ORM\UniqueConstraint(name="idCancion_UNIQUE", columns={"idCancion"})})
 * @ORM\Entity
 */
class CancionesWeek
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
     * @var int
     *
     * @ORM\Column(name="Reproducciones", type="integer", nullable=false)
     */
    private $reproducciones;

    /**
     * @var int
     *
     * @ORM\Column(name="Puesto", type="integer", nullable=false)
     */
    private $puesto;




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
