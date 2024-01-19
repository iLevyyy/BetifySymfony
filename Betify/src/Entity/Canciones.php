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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Artistas", inversedBy="cancionesIdcancion")
     * @ORM\JoinTable(name="canciones_has_artistas",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Canciones_idCancion", referencedColumnName="idCancion")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Artistas_idArtista", referencedColumnName="idArtista")
     *   }
     * )
     */
    private $artistasIdartista = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->artistasIdartista = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
