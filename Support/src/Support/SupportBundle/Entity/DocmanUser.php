<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanUser
 *
 * @ORM\Table(name="docman_user", indexes={@ORM\Index(name="fk_ofi", columns={"oficina"}), @ORM\Index(name="user", columns={"username"})})
 * @ORM\Entity
 */
class DocmanUser
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
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50, nullable=false)
     */
    private $password;

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
     * @ORM\Column(name="ci", type="string", length=15, nullable=false)
     */
    private $ci;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datereg", type="datetime", nullable=false)
     */
    private $datereg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastaccess", type="datetime", nullable=false)
     */
    private $lastaccess;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer", nullable=false)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=1, nullable=false)
     */
    private $type;

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
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefref", type="string", length=15, nullable=false)
     */
    private $telefref;

    /**
     * @var string
     *
     * @ORM\Column(name="numseguro", type="string", length=10, nullable=false)
     */
    private $numseguro;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=100, nullable=false)
     */
    private $cargo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechanac", type="date", nullable=false)
     */
    private $fechanac = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=false)
     */
    private $ip;

    /**
     * @var integer
     *
     * @ORM\Column(name="depende_de", type="integer", nullable=false)
     */
    private $dependeDe;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=50, nullable=false)
     */
    private $foto;

    /**
     * @var string
     *
     * @ORM\Column(name="soporte", type="string", length=255, nullable=false)
     */
    private $soporte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modif", type="datetime", nullable=true)
     */
    private $fechaModif;

    /**
     * @var string
     *
     * @ORM\Column(name="ip2", type="string", length=15, nullable=true)
     */
    private $ip2;

    /**
     * @var string
     *
     * @ORM\Column(name="externo", type="string", length=2, nullable=true)
     */
    private $externo;

    /**
     * @var \DocmanOficina
     *
     * @ORM\ManyToOne(targetEntity="DocmanOficina")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="oficina", referencedColumnName="id")
     * })
     */
    private $oficina;



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
     * Set name
     *
     * @param string $name
     * @return DocmanUser
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
     * @return DocmanUser
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
     * Set username
     *
     * @param string $username
     * @return DocmanUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return DocmanUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set movil
     *
     * @param string $movil
     * @return DocmanUser
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
     * @return DocmanUser
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
     * Set ci
     *
     * @param string $ci
     * @return DocmanUser
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

    /**
     * Set datereg
     *
     * @param \DateTime $datereg
     * @return DocmanUser
     */
    public function setDatereg($datereg)
    {
        $this->datereg = $datereg;

        return $this;
    }

    /**
     * Get datereg
     *
     * @return \DateTime 
     */
    public function getDatereg()
    {
        return $this->datereg;
    }

    /**
     * Set lastaccess
     *
     * @param \DateTime $lastaccess
     * @return DocmanUser
     */
    public function setLastaccess($lastaccess)
    {
        $this->lastaccess = $lastaccess;

        return $this;
    }

    /**
     * Get lastaccess
     *
     * @return \DateTime 
     */
    public function getLastaccess()
    {
        return $this->lastaccess;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return DocmanUser
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return DocmanUser
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return DocmanUser
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
     * @return DocmanUser
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
     * Set telefref
     *
     * @param string $telefref
     * @return DocmanUser
     */
    public function setTelefref($telefref)
    {
        $this->telefref = $telefref;

        return $this;
    }

    /**
     * Get telefref
     *
     * @return string 
     */
    public function getTelefref()
    {
        return $this->telefref;
    }

    /**
     * Set numseguro
     *
     * @param string $numseguro
     * @return DocmanUser
     */
    public function setNumseguro($numseguro)
    {
        $this->numseguro = $numseguro;

        return $this;
    }

    /**
     * Get numseguro
     *
     * @return string 
     */
    public function getNumseguro()
    {
        return $this->numseguro;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return DocmanUser
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
     * Set fechanac
     *
     * @param \DateTime $fechanac
     * @return DocmanUser
     */
    public function setFechanac($fechanac)
    {
        $this->fechanac = $fechanac;

        return $this;
    }

    /**
     * Get fechanac
     *
     * @return \DateTime 
     */
    public function getFechanac()
    {
        return $this->fechanac;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return DocmanUser
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set dependeDe
     *
     * @param integer $dependeDe
     * @return DocmanUser
     */
    public function setDependeDe($dependeDe)
    {
        $this->dependeDe = $dependeDe;

        return $this;
    }

    /**
     * Get dependeDe
     *
     * @return integer 
     */
    public function getDependeDe()
    {
        return $this->dependeDe;
    }

    /**
     * Set foto
     *
     * @param string $foto
     * @return DocmanUser
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string 
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set soporte
     *
     * @param string $soporte
     * @return DocmanUser
     */
    public function setSoporte($soporte)
    {
        $this->soporte = $soporte;

        return $this;
    }

    /**
     * Get soporte
     *
     * @return string 
     */
    public function getSoporte()
    {
        return $this->soporte;
    }

    /**
     * Set fechaModif
     *
     * @param \DateTime $fechaModif
     * @return DocmanUser
     */
    public function setFechaModif($fechaModif)
    {
        $this->fechaModif = $fechaModif;

        return $this;
    }

    /**
     * Get fechaModif
     *
     * @return \DateTime 
     */
    public function getFechaModif()
    {
        return $this->fechaModif;
    }

    /**
     * Set ip2
     *
     * @param string $ip2
     * @return DocmanUser
     */
    public function setIp2($ip2)
    {
        $this->ip2 = $ip2;

        return $this;
    }

    /**
     * Get ip2
     *
     * @return string 
     */
    public function getIp2()
    {
        return $this->ip2;
    }

    /**
     * Set externo
     *
     * @param string $externo
     * @return DocmanUser
     */
    public function setExterno($externo)
    {
        $this->externo = $externo;

        return $this;
    }

    /**
     * Get externo
     *
     * @return string 
     */
    public function getExterno()
    {
        return $this->externo;
    }

    /**
     * Set oficina
     *
     * @param \Support\SupportBundle\Entity\DocmanOficina $oficina
     * @return DocmanUser
     */
    public function setOficina(\Support\SupportBundle\Entity\DocmanOficina $oficina = null)
    {
        $this->oficina = $oficina;

        return $this;
    }

    /**
     * Get oficina
     *
     * @return \Support\SupportBundle\Entity\DocmanOficina 
     */
    public function getOficina()
    {
        return $this->oficina;
    }
}
