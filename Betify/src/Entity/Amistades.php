<?php 

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmistadesRepository")
 */
class Amistades
{
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuarios")
     * @ORM\JoinColumn(name="Usuario1_idUsuario", referencedColumnName="idUsuario", nullable=false)
     */
    private $usuario1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuarios")
     * @ORM\JoinColumn(name="Usuario2_idUsuario", referencedColumnName="idUsuario", nullable=false)
     */
    private $usuario2;

    public function __construct($usuario1, $usuario2)
    {
        $this->usuario1 = $usuario1;
        $this->usuario2 = $usuario2;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario1(): ?Usuarios
    {
        return $this->usuario1;
    }

    public function setUsuario1(?Usuarios $usuario1): self
    {
        $this->usuario1 = $usuario1;

        return $this;
    }

    public function getUsuario2(): ?Usuarios
    {
        return $this->usuario2;
    }

    public function setUsuario2(?Usuarios $usuario2): self
    {
        $this->usuario2 = $usuario2;

        return $this;
    }
}
