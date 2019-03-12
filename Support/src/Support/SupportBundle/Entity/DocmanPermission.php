<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanPermission
 *
 * @ORM\Table(name="docman_permission", indexes={@ORM\Index(name="file", columns={"file"})})
 * @ORM\Entity
 */
class DocmanPermission
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
     * @ORM\Column(name="users", type="string", length=3, nullable=false)
     */
    private $users;

    /**
     * @var string
     *
     * @ORM\Column(name="groups", type="string", length=3, nullable=false)
     */
    private $groups;

    /**
     * @var \DocmanFile
     *
     * @ORM\ManyToOne(targetEntity="DocmanFile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="file", referencedColumnName="idf")
     * })
     */
    private $file;



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
     * Set users
     *
     * @param string $users
     * @return DocmanPermission
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return string 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set groups
     *
     * @param string $groups
     * @return DocmanPermission
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Get groups
     *
     * @return string 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set file
     *
     * @param \Support\SupportBundle\Entity\DocmanFile $file
     * @return DocmanPermission
     */
    public function setFile(\Support\SupportBundle\Entity\DocmanFile $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \Support\SupportBundle\Entity\DocmanFile 
     */
    public function getFile()
    {
        return $this->file;
    }
}
