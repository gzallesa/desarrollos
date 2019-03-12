<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanLoginLog
 *
 * @ORM\Table(name="docman_login_log", indexes={@ORM\Index(name="fk_user", columns={"usuario"})})
 * @ORM\Entity
 */
class DocmanLoginLog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inicio", type="time", nullable=false)
     */
    private $inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="time", nullable=true)
     */
    private $fin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var \DocmanUser
     *
     * @ORM\ManyToOne(targetEntity="DocmanUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set inicio
     *
     * @param \DateTime $inicio
     * @return DocmanLoginLog
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime 
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return DocmanLoginLog
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime 
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return DocmanLoginLog
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set usuario
     *
     * @param \Support\SupportBundle\Entity\DocmanUser $usuario
     * @return DocmanLoginLog
     */
    public function setUsuario(\Support\SupportBundle\Entity\DocmanUser $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Support\SupportBundle\Entity\DocmanUser 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
