<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MonKeyword
 *
 * @ORM\Table(name="mon_keyword")
 * @ORM\Entity
 */
class MonKeyword
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
     * @ORM\Column(name="palabra", type="string", length=500, nullable=false)
     */
    private $palabra;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=false)
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="cliente", type="integer", nullable=false)
     */
    private $cliente;



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
     * Set palabra
     *
     * @param string $palabra
     * @return MonKeyword
     */
    public function setPalabra($palabra)
    {
        $this->palabra = $palabra;

        return $this;
    }

    /**
     * Get palabra
     *
     * @return string 
     */
    public function getPalabra()
    {
        return $this->palabra;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return MonKeyword
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cliente
     *
     * @param integer $cliente
     * @return MonKeyword
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return integer 
     */
    public function getCliente()
    {
        return $this->cliente;
    }
}
