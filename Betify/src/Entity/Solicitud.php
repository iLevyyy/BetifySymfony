<?php

namespace App\Entity;

use App\Entity\Usuarios;
use Doctrine\ORM\Mapping as ORM;

/**
 * Solicitud
 *
 * @ORM\Table(name="solicitud")
 * @ORM\Entity
 */
class Solicitud
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuarios", cascade={"remove"})
     * @ORM\JoinColumn(name="remitente_id", referencedColumnName="idUsuario", nullable=false, onDelete="CASCADE")
     */
    private $remitente;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuarios", cascade={"remove"})
     * @ORM\JoinColumn(name="receptor_id", referencedColumnName="idUsuario", nullable=false, onDelete="CASCADE")
     */
    private $receptor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRemitente(): ?Usuarios
    {
        return $this->remitente;
    }

    public function setRemitente(?Usuarios $remitente): self
    {
        $this->remitente = $remitente;

        return $this;
    }

    public function getReceptor(): ?Usuarios
    {
        return $this->receptor;
    }

    public function setReceptor(?Usuarios $receptor): self
    {
        $this->receptor = $receptor;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
}
