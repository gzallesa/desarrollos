<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MonCliFue
 *
 * @ORM\Table(name="mon_cli_fue")
 * @ORM\Entity
 */
class MonCliFue
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
     * @var integer
     *
     * @ORM\Column(name="cliente", type="integer", nullable=false)
     */
    private $cliente;

    /**
     * @var integer
     *
     * @ORM\Column(name="fuente", type="integer", nullable=false)
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
     * Set cliente
     *
     * @param integer $cliente
     * @return MonCliFue
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

    /**
     * Set fuente
     *
     * @param integer $fuente
     * @return MonCliFue
     */
    public function setFuente($fuente)
    {
        $this->fuente = $fuente;

        return $this;
    }

    /**
     * Get fuente
     *
     * @return integer 
     */
    public function getFuente()
    {
        return $this->fuente;
    }
}
