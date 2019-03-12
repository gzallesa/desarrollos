<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gcm
 *
 * @ORM\Table(name="gcm")
 * @ORM\Entity
 */
class Gcm
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
     * @ORM\Column(name="regid", type="string", length=255, nullable=false)
     */
    private $regid;

    /**
     * @var string
     *
     * @ORM\Column(name="imei", type="string", length=100, nullable=false)
     */
    private $imei;



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
     * Set regid
     *
     * @param string $regid
     * @return Gcm
     */
    public function setRegid($regid)
    {
        $this->regid = $regid;

        return $this;
    }

    /**
     * Get regid
     *
     * @return string 
     */
    public function getRegid()
    {
        return $this->regid;
    }

    /**
     * Set imei
     *
     * @param string $imei
     * @return Gcm
     */
    public function setImei($imei)
    {
        $this->imei = $imei;

        return $this;
    }

    /**
     * Get imei
     *
     * @return string 
     */
    public function getImei()
    {
        return $this->imei;
    }
}
