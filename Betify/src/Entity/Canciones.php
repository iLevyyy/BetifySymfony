<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Canciones
 *
 * @ORM\Table(name="canciones", uniqueConstraints={@ORM\UniqueConstraint(name="idCancion_UNIQUE", columns={"idCancion"})})
 * @ORM\Entity
 */
class Canciones
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
}