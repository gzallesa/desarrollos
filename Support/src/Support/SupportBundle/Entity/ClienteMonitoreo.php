<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClienteMonitoreo
 *
 * @ORM\Table(name="cliente_monitoreo")
 * @ORM\Entity
 */
class ClienteMonitoreo
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
     * @ORM\Column(name="nombre_cliente", type="string", length=500, nullable=false)
     */
    private $nombreCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="entidad", type="string", length=200, nullable=false)
     */
    private $entidad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_reg", type="datetime", nullable=false)
     */
    private $fechaReg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultimo_acceso", type="datetime", nullable=false)
     */
    private $ultimoAcceso = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="pass", type="string", length=100, nullable=false)
     */
    private $pass;



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
     * Set nombreCliente
     *
     * @param string $nombreCliente
     * @return ClienteMonitoreo
     */
    public function setNombreCliente($nombreCliente)
    {
        $this->nombreCliente = $nombreCliente;

        return $this;
    }

    /**
     * Get nombreCliente
     *
     * @return string 
     */
    public function getNombreCliente()
    {
        return $this->nombreCliente;
    }

    /**
     * Set entidad
     *
     * @param string $entidad
     * @return ClienteMonitoreo
     */
    public function setEntidad($entidad)
    {
        $this->entidad = $entidad;

        return $this;
    }

    /**
     * Get entidad
     *
     * @return string 
     */
    public function getEntidad()
    {
        return $this->entidad;
    }

    /**
     * Set fechaReg
     *
     * @param \DateTime $fechaReg
     * @return ClienteMonitoreo
     */
    public function setFechaReg($fechaReg)
    {
        $this->fechaReg = $fechaReg;

        return $this;
    }

    /**
     * Get fechaReg
     *
     * @return \DateTime 
     */
    public function getFechaReg()
    {
        return $this->fechaReg;
    }

    /**
     * Set ultimoAcceso
     *
     * @param \DateTime $ultimoAcceso
     * @return ClienteMonitoreo
     */
    public function setUltimoAcceso($ultimoAcceso)
    {
        $this->ultimoAcceso = $ultimoAcceso;

        return $this;
    }

    /**
     * Get ultimoAcceso
     *
     * @return \DateTime 
     */
    public function getUltimoAcceso()
    {
        return $this->ultimoAcceso;
    }

    /**
     * Set pass
     *
     * @param string $pass
     * @return ClienteMonitoreo
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string 
     */
    public function getPass()
    {
        return $this->pass;
    }
}
