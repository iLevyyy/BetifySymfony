<?php

namespace App\Entity;

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
     * Obtener el valor de idartista
     *
     * @return int
     */
    public function getIdArtista(): int
    {
        return $this->idartista;
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
