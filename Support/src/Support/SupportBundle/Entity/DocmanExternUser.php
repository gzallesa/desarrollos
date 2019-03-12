<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanExternUser
 *
 * @ORM\Table(name="docman_extern_user", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity
 */
class DocmanExternUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idu", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="movil", type="string", length=10, nullable=false)
     */
    private $movil;

    /**
     * @var string
     *
     * @ORM\Column(name="interno", type="string", length=10, nullable=false)
     */
    private $interno;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=15, nullable=false)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=false)
     */
    private $direccion = 'MOPSV';

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=255, nullable=false)
     */
    private $cargo;

    /**
     * @var integer
     *
     * @ORM\Column(name="institucion", type="integer", nullable=false)
     */
    private $institucion;

    /**
     * @var string
     *
     * @ORM\Column(name="ci", type="string", length=15, nullable=false)
     */
    private $ci;



    /**
     * Get idu
     *
     * @return integer 
     */
    public function getIdu()
    {
        return $this->idu;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return DocmanExternUser
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
     * Set email
     *
     * @param string $email
     * @return DocmanExternUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set movil
     *
     * @param string $movil
     * @return DocmanExternUser
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get movil
     *
     * @return string 
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * Set interno
     *
     * @param string $interno
     * @return DocmanExternUser
     */
    public function setInterno($interno)
    {
        $this->interno = $interno;

        return $this;
    }

    /**
     * Get interno
     *
     * @return string 
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return DocmanExternUser
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return DocmanExternUser
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return DocmanExternUser
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set institucion
     *
     * @param integer $institucion
     * @return DocmanExternUser
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;

        return $this;
    }

    /**
     * Get institucion
     *
     * @return integer 
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }

    /**
     * Set ci
     *
     * @param string $ci
     * @return DocmanExternUser
     */
    public function setCi($ci)
    {
        $this->ci = $ci;

        return $this;
    }

    /**
     * Get ci
     *
     * @return string 
     */
    public function getCi()
    {
        return $this->ci;
    }
}
