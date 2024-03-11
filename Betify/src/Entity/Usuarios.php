<?php

namespace App\Entity;

use App\Entity\Apuestas;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios", uniqueConstraints={@ORM\UniqueConstraint(name="NombreUsuario_UNIQUE", columns={"NombreUsuario"}), @ORM\UniqueConstraint(name="idUsuario_UNIQUE", columns={"idUsuario"}), @ORM\UniqueConstraint(name="Email_UNIQUE", columns={"Email"})})
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
     * @var string
     *
     * @ORM\Column(name="NombreUsuario", type="string", length=45, nullable=false)
     */
    private $nombreusuario;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="Creditos", type="integer", nullable=false, options={"default"=0})
     */
    private $creditos = 0;


    /**
     * @var string|null
     *
     * @ORM\Column(name="Password", type="string", length=45, nullable=true, options={"default"="NULL"})
     */
    private $password = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="isAdmin", type="boolean", length=45, nullable=true)
     */
    private $isadmin = '0';
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
    private $apuestas;

    public function addApuesta(Apuestas $apuesta): void
    {
        $this->apuestas[] = $apuesta;
    }
    /**
     * Obtener el valor de idusuario
     *
     * @return int
     */
    public function getIdUsuario(): int
    {
        return $this->idusuario;
    }
    public function getCreditos(): int
    {
        return $this->creditos;
    }

    /**
     * Obtener el valor de nombreusuario
     *
     * @return string
     */
    public function getNombreUsuario(): string
    {
        return $this->nombreusuario;
    }
    public function setCreditos(int $creditos): void
    {
        $this->creditos = $creditos;
    }

    /**
     * Establecer el valor de nombreusuario
     *
     * @param string $nombreusuario
     */
    public function setNombreUsuario(string $nombreusuario): void
    {
        $this->nombreusuario = $nombreusuario;
    }

    /**
     * Obtener el valor de email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Establecer el valor de email
     *
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Obtener el valor de password
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Establecer el valor de password
     *
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    // /**
    //  * Obtener la colección de apuestasIdapuesta
    //  *
    //  * @return \Doctrine\Common\Collections\Collection
    //  */
    // public function getApuestasIdapuesta(): \Doctrine\Common\Collections\Collection
    // {
    //     return $this->apuestasIdapuesta;
    // }


}
