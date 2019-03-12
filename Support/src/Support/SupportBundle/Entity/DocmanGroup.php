<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanGroup
 *
 * @ORM\Table(name="docman_group", uniqueConstraints={@ORM\UniqueConstraint(name="longname", columns={"longname"})})
 * @ORM\Entity
 */
class DocmanGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idg", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idg;

    /**
     * @var string
     *
     * @ORM\Column(name="longname", type="string", length=50, nullable=false)
     */
    private $longname;

    /**
     * @var integer
     *
     * @ORM\Column(name="folder", type="integer", nullable=false)
     */
    private $folder;



    /**
     * Get idg
     *
     * @return integer 
     */
    public function getIdg()
    {
        return $this->idg;
    }

    /**
     * Set longname
     *
     * @param string $longname
     * @return DocmanGroup
     */
    public function setLongname($longname)
    {
        $this->longname = $longname;

        return $this;
    }

    /**
     * Get longname
     *
     * @return string 
     */
    public function getLongname()
    {
        return $this->longname;
    }

    /**
     * Set folder
     *
     * @param integer $folder
     * @return DocmanGroup
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get folder
     *
     * @return integer 
     */
    public function getFolder()
    {
        return $this->folder;
    }
}
