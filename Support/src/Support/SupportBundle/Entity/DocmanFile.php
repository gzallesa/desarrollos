<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanFile
 *
 * @ORM\Table(name="docman_file")
 * @ORM\Entity
 */
class DocmanFile
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
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $filename;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="ext", type="string", length=5, nullable=false)
     */
    private $ext;

    /**
     * @var integer
     *
     * @ORM\Column(name="filesize", type="integer", nullable=false)
     */
    private $filesize;

    /**
     * @var integer
     *
     * @ORM\Column(name="parentfolder", type="integer", nullable=false)
     */
    private $parentfolder;

    /**
     * @var integer
     *
     * @ORM\Column(name="user", type="integer", nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=100, nullable=false)
     */
    private $path;



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
     * Set filename
     *
     * @param string $filename
     * @return DocmanFile
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return DocmanFile
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set ext
     *
     * @param string $ext
     * @return DocmanFile
     */
    public function setExt($ext)
    {
        $this->ext = $ext;

        return $this;
    }

    /**
     * Get ext
     *
     * @return string 
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * Set filesize
     *
     * @param integer $filesize
     * @return DocmanFile
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;

        return $this;
    }

    /**
     * Get filesize
     *
     * @return integer 
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * Set parentfolder
     *
     * @param integer $parentfolder
     * @return DocmanFile
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
     * Set user
     *
     * @param integer $user
     * @return DocmanFile
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

    /**
     * Set status
     *
     * @param string $status
     * @return DocmanFile
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
     * Set path
     *
     * @param string $path
     * @return DocmanFile
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
}
