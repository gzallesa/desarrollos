<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanContenido
 *
 * @ORM\Table(name="docman_contenido", indexes={@ORM\Index(name="fk_cont", columns={"tipo"}), @ORM\Index(name="fk_usr", columns={"usuario"})})
 * @ORM\Entity
 */
class DocmanContenido
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
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=500, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=500, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=500, nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="embebido", type="text", nullable=true)
     */
    private $embebido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pub", type="datetime", nullable=true)
     */
    private $fechaPub;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_limite", type="datetime", nullable=true)
     */
    private $fechaLimite;

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
     * Set titulo
     *
     * @param string $titulo
     * @return DocmanContenido
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DocmanContenido
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
     * Set url
     *
     * @param string $url
     * @return DocmanContenido
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return DocmanContenido
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set embebido
     *
     * @param string $embebido
     * @return DocmanContenido
     */
    public function setEmbebido($embebido)
    {
        $this->embebido = $embebido;

        return $this;
    }

    /**
     * Get embebido
     *
     * @return string 
     */
    public function getEmbebido()
    {
        return $this->embebido;
    }

    /**
     * Set fechaPub
     *
     * @param \DateTime $fechaPub
     * @return DocmanContenido
     */
    public function setFechaPub($fechaPub)
    {
        $this->fechaPub = $fechaPub;

        return $this;
    }

    /**
     * Get fechaPub
     *
     * @return \DateTime 
     */
    public function getFechaPub()
    {
        return $this->fechaPub;
    }

    /**
     * Set fechaLimite
     *
     * @param \DateTime $fechaLimite
     * @return DocmanContenido
     */
    public function setFechaLimite($fechaLimite)
    {
        $this->fechaLimite = $fechaLimite;

        return $this;
    }

    /**
     * Get fechaLimite
     *
     * @return \DateTime 
     */
    public function getFechaLimite()
    {
        return $this->fechaLimite;
    }

    /**
     * Set tipo
     *
     * @param \Support\SupportBundle\Entity\DocmanTipoContenido $tipo
     * @return DocmanContenido
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

    /**
     * Set usuario
     *
     * @param \Support\SupportBundle\Entity\DocmanUser $usuario
     * @return DocmanContenido
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
