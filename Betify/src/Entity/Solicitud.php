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
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Usuarios")
     * @ORM\JoinColumn(referencedColumnName="idUsuario",nullable=false)
     */
    private $remitente;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Usuarios")
     * @ORM\JoinColumn(referencedColumnName="idUsuario",nullable=false)
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
