<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanProvider
 *
 * @ORM\Table(name="docman_provider", indexes={@ORM\Index(name="grupo", columns={"group"})})
 * @ORM\Entity
 */
class DocmanProvider
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
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=15, nullable=false)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=15, nullable=false)
     */
    private $celular;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=15, nullable=false)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pagina", type="string", length=255, nullable=false)
     */
    private $pagina;

    /**
     * @var \DocmanGroup
     *
     * @ORM\ManyToOne(targetEntity="DocmanGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group", referencedColumnName="idg")
     * })
     */
    private $group;



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
     * @return DocmanProvider
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
     * Set telefono
     *
     * @param string $telefono
     * @return DocmanProvider
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return DocmanProvider
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return DocmanProvider
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return DocmanProvider
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return DocmanProvider
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pagina
     *
     * @param string $pagina
     * @return DocmanProvider
     */
    public function setPagina($pagina)
    {
        $this->pagina = $pagina;

        return $this;
    }

    /**
     * Get pagina
     *
     * @return string 
     */
    public function getPagina()
    {
        return $this->pagina;
    }

    /**
     * Set group
     *
     * @param \Support\SupportBundle\Entity\DocmanGroup $group
     * @return DocmanProvider
     */
    public function setGroup(\Support\SupportBundle\Entity\DocmanGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Support\SupportBundle\Entity\DocmanGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }
}
