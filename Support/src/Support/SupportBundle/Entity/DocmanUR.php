<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanUR
 *
 * @ORM\Table(name="docman_u_r")
 * @ORM\Entity
 */
class DocmanUR
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
     * @ORM\Column(name="refidu", type="integer", nullable=false)
     */
    private $refidu;

    /**
     * @var integer
     *
     * @ORM\Column(name="refidr", type="integer", nullable=false)
     */
    private $refidr;



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
     * Set refidu
     *
     * @param integer $refidu
     * @return DocmanUR
     */
    public function setRefidu($refidu)
    {
        $this->refidu = $refidu;

        return $this;
    }

    /**
     * Get refidu
     *
     * @return integer 
     */
    public function getRefidu()
    {
        return $this->refidu;
    }

    /**
     * Set refidr
     *
     * @param integer $refidr
     * @return DocmanUR
     */
    public function setRefidr($refidr)
    {
        $this->refidr = $refidr;

        return $this;
    }

    /**
     * Get refidr
     *
     * @return integer 
     */
    public function getRefidr()
    {
        return $this->refidr;
    }
}
