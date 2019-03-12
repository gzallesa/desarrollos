<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MonCliKey
 *
 * @ORM\Table(name="mon_cli_key")
 * @ORM\Entity
 */
class MonCliKey
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
     * @ORM\Column(name="keyword", type="integer", nullable=false)
     */
    private $keyword;



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
     * @return MonCliKey
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
     * Set keyword
     *
     * @param integer $keyword
     * @return MonCliKey
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return integer 
     */
    public function getKeyword()
    {
        return $this->keyword;
    }
}
