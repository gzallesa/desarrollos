<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanFolderPermission
 *
 * @ORM\Table(name="docman_folder_permission", indexes={@ORM\Index(name="f", columns={"file"})})
 * @ORM\Entity
 */
class DocmanFolderPermission
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
     * @var \DocmanFolder
     *
     * @ORM\ManyToOne(targetEntity="DocmanFolder")
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
     * @return DocmanFolderPermission
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
     * @return DocmanFolderPermission
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
     * @param \Support\SupportBundle\Entity\DocmanFolder $file
     * @return DocmanFolderPermission
     */
    public function setFile(\Support\SupportBundle\Entity\DocmanFolder $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \Support\SupportBundle\Entity\DocmanFolder 
     */
    public function getFile()
    {
        return $this->file;
    }
}
