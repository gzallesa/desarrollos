<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanRules
 *
 * @ORM\Table(name="docman_rules")
 * @ORM\Entity
 */
class DocmanRules
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idr", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idr;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;



    /**
     * Get idr
     *
     * @return integer 
     */
    public function getIdr()
    {
        return $this->idr;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return DocmanRules
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
