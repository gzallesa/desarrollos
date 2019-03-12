<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanFolder
 *
 * @ORM\Table(name="docman_folder")
 * @ORM\Entity
 */
class DocmanFolder
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idf", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idf;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=200, nullable=false)
     */
    private $path;

    /**
     * @var integer
     *
     * @ORM\Column(name="parentfolder", type="integer", nullable=false)
     */
    private $parentfolder;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdate", type="datetime", nullable=false)
     */
    private $createdate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    private $status = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="user", type="integer", nullable=true)
     */
    private $user;



    /**
     * Get idf
     *
     * @return integer 
     */
    public function getIdf()
    {
        return $this->idf;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return DocmanFolder
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return DocmanFolder
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set parentfolder
     *
     * @param integer $parentfolder
     * @return DocmanFolder
     */
    public function setParentfolder($parentfolder)
    {
        $this->parentfolder = $parentfolder;

        return $this;
    }

    /**
     * Get parentfolder
     *
     * @return integer 
     */
    public function getParentfolder()
    {
        return $this->parentfolder;
    }

    /**
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return DocmanFolder
     */
    public function setCreatedate($createdate)
    {
        $this->createdate = $createdate;

        return $this;
    }

    /**
     * Get createdate
     *
     * @return \DateTime 
     */
    public function getCreatedate()
    {
        return $this->createdate;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return DocmanFolder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param integer $user
     * @return DocmanFolder
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
