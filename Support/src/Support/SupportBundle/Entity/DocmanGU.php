<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanGU
 *
 * @ORM\Table(name="docman_g_u")
 * @ORM\Entity
 */
class DocmanGU
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ingroup", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ingroup;

    /**
     * @var integer
     *
     * @ORM\Column(name="user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $user;



    /**
     * Set ingroup
     *
     * @param integer $ingroup
     * @return DocmanGU
     */
    public function setIngroup($ingroup)
    {
        $this->ingroup = $ingroup;

        return $this;
    }

    /**
     * Get ingroup
     *
     * @return integer 
     */
    public function getIngroup()
    {
        return $this->ingroup;
    }

    /**
     * Set user
     *
     * @param integer $user
     * @return DocmanGU
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }
}
