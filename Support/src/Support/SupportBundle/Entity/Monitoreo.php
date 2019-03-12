<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Monitoreo
 *
 * @ORM\Table(name="monitoreo", indexes={@ORM\Index(name="fk_fuente", columns={"fuente"})})
 * @ORM\Entity
 */
class Monitoreo
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pubDate", type="date", nullable=true)
     */
    private $pubdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="ext", type="integer", nullable=true)
     */
    private $ext;

    /**
     * @var string
     *
     * @ORM\Column(name="firma", type="string", length=50, nullable=true)
     */
    private $firma;

    /**
     * @var \Fuente
     *
     * @ORM\ManyToOne(targetEntity="Fuente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fuente", referencedColumnName="id")
     * })
     */
    private $fuente;



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
     * Set title
     *
     * @param string $title
     * @return Monitoreo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Monitoreo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Monitoreo
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set pubdate
     *
     * @param \DateTime $pubdate
     * @return Monitoreo
     */
    public function setPubdate($pubdate)
    {
        $this->pubdate = $pubdate;

        return $this;
    }

    /**
     * Get pubdate
     *
     * @return \DateTime 
     */
    public function getPubdate()
    {
        return $this->pubdate;
    }

    /**
     * Set ext
     *
     * @param integer $ext
     * @return Monitoreo
     */
    public function setExt($ext)
    {
        $this->ext = $ext;

        return $this;
    }

    /**
     * Get ext
     *
     * @return integer 
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * Set firma
     *
     * @param string $firma
     * @return Monitoreo
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma
     *
     * @return string 
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Set fuente
     *
     * @param \Support\SupportBundle\Entity\Fuente $fuente
     * @return Monitoreo
     */
    public function setFuente(\Support\SupportBundle\Entity\Fuente $fuente = null)
    {
        $this->fuente = $fuente;

        return $this;
    }

    /**
     * Get fuente
     *
     * @return \Support\SupportBundle\Entity\Fuente 
     */
    public function getFuente()
    {
        return $this->fuente;
    }
}
