<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios", uniqueConstraints={@ORM\UniqueConstraint(name="idUsuario_UNIQUE", columns={"idUsuario"}), @ORM\UniqueConstraint(name="Email_UNIQUE", columns={"Email"}), @ORM\UniqueConstraint(name="NombreUsuario_UNIQUE", columns={"NombreUsuario"})})
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

}
