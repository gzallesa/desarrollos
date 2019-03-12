<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipusr
 *
 * @ORM\Table(name="tipusr", indexes={@ORM\Index(name="fkaa1", columns={"usuario"}), @ORM\Index(name="fkaa2", columns={"tipo"})})
 * @ORM\Entity
 */
class Tipusr
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
     * @var \DocmanUser
     *
     * @ORM\ManyToOne(targetEntity="DocmanUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var \DocmanTipoContenido
     *
     * @ORM\ManyToOne(targetEntity="DocmanTipoContenido")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo", referencedColumnName="id")
     * })
     */
    private $tipo;



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
     * Set usuario
     *
     * @param \Support\SupportBundle\Entity\DocmanUser $usuario
     * @return Tipusr
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

    /**
     * Set tipo
     *
     * @param \Support\SupportBundle\Entity\DocmanTipoContenido $tipo
     * @return Tipusr
     */
    public function setTipo(\Support\SupportBundle\Entity\DocmanTipoContenido $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \Support\SupportBundle\Entity\DocmanTipoContenido 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}
