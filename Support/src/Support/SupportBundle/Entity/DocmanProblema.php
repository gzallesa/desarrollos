<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanProblema
 *
 * @ORM\Table(name="docman_problema", indexes={@ORM\Index(name="fk_usr1", columns={"fun"})})
 * @ORM\Entity
 */
class DocmanProblema
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idp;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @var \DocmanUser
     *
     * @ORM\ManyToOne(targetEntity="DocmanUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fun", referencedColumnName="id")
     * })
     */
    private $fun;



    /**
     * Get idp
     *
     * @return integer 
     */
    public function getIdp()
    {
        return $this->idp;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return DocmanProblema
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

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DocmanProblema
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return DocmanProblema
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set fun
     *
     * @param \Support\SupportBundle\Entity\DocmanUser $fun
     * @return DocmanProblema
     */
    public function setFun(\Support\SupportBundle\Entity\DocmanUser $fun = null)
    {
        $this->fun = $fun;

        return $this;
    }

    /**
     * Get fun
     *
     * @return \Support\SupportBundle\Entity\DocmanUser 
     */
    public function getFun()
    {
        return $this->fun;
    }
}
