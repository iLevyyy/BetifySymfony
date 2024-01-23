<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios", uniqueConstraints={@ORM\UniqueConstraint(name="Email_UNIQUE", columns={"Email"}), @ORM\UniqueConstraint(name="idUsuario_UNIQUE", columns={"idUsuario"}), @ORM\UniqueConstraint(name="NombreUsuario_UNIQUE", columns={"NombreUsuario"})})
 * @ORM\Entity
 */
class Usuarios
{
    /**
     * @var int
     *
     * @ORM\Column(name="idUsuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuario;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NombreUsuario", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $nombreusuario = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Email", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $email = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Password", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $password = 'NULL';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Apuestas", inversedBy="usuariosIdusuario")
     * @ORM\JoinTable(name="usuarios_has_apuestas",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Usuarios_idUsuario", referencedColumnName="idUsuario")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Apuestas_idApuesta", referencedColumnName="idApuesta")
     *   }
     * )
     */
    private $apuestasIdapuesta = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->apuestasIdapuesta = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdusuario(): ?int
    {
        return $this->idusuario;
    }

    public function getNombreusuario(): ?string
    {
        return $this->nombreusuario;
    }

    public function setNombreusuario(?string $nombreusuario): static
    {
        $this->nombreusuario = $nombreusuario;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Apuestas>
     */
    public function getApuestasIdapuesta(): Collection
    {
        return $this->apuestasIdapuesta;
    }

    public function addApuestasIdapuestum(Apuestas $apuestasIdapuestum): static
    {
        if (!$this->apuestasIdapuesta->contains($apuestasIdapuestum)) {
            $this->apuestasIdapuesta->add($apuestasIdapuestum);
        }

        return $this;
    }

    public function removeApuestasIdapuestum(Apuestas $apuestasIdapuestum): static
    {
        $this->apuestasIdapuesta->removeElement($apuestasIdapuestum);

        return $this;
    }

}
