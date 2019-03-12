<?php

namespace Support\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocmanSolicitud
 *
 * @ORM\Table(name="docman_solicitud", indexes={@ORM\Index(name="sop", columns={"solicitante"}), @ORM\Index(name="fk_sop", columns={"estado"}), @ORM\Index(name="fk_prob", columns={"problema"}), @ORM\Index(name="fk_soportex", columns={"soporte"})})
 * @ORM\Entity
 */
class DocmanSolicitud
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
     * @ORM\Column(name="estado", type="string", length=5, nullable=false)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_solicitud", type="time", nullable=false)
     */
    private $horaSolicitud;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_atencion", type="time", nullable=true)
     */
    private $horaAtencion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="prioridad", type="string", length=5, nullable=false)
     */
    private $prioridad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_solicitud", type="date", nullable=false)
     */
    private $fechaSolicitud;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_solucion", type="date", nullable=true)
     */
    private $fechaSolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="derivado", type="string", length=2, nullable=true)
     */
    private $derivado;

    /**
     * @var \DocmanProblema
     *
     * @ORM\ManyToOne(targetEntity="DocmanProblema")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="problema", referencedColumnName="idp")
     * })
     */
    private $problema;

    /**
     * @var \DocmanUser
     *
     * @ORM\ManyToOne(targetEntity="DocmanUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="solicitante", referencedColumnName="id")
     * })
     */
    private $solicitante;

    /**
     * @var \DocmanUser
     *
     * @ORM\ManyToOne(targetEntity="DocmanUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="soporte", referencedColumnName="id")
     * })
     */
    private $soporte;



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
     * Set estado
     *
     * @param string $estado
     * @return DocmanSolicitud
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set horaSolicitud
     *
     * @param \DateTime $horaSolicitud
     * @return DocmanSolicitud
     */
    public function setHoraSolicitud($horaSolicitud)
    {
        $this->horaSolicitud = $horaSolicitud;

        return $this;
    }

    /**
     * Get horaSolicitud
     *
     * @return \DateTime 
     */
    public function getHoraSolicitud()
    {
        return $this->horaSolicitud;
    }

    /**
     * Set horaAtencion
     *
     * @param \DateTime $horaAtencion
     * @return DocmanSolicitud
     */
    public function setHoraAtencion($horaAtencion)
    {
        $this->horaAtencion = $horaAtencion;

        return $this;
    }

    /**
     * Get horaAtencion
     *
     * @return \DateTime 
     */
    public function getHoraAtencion()
    {
        return $this->horaAtencion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return DocmanSolicitud
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set prioridad
     *
     * @param string $prioridad
     * @return DocmanSolicitud
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return string 
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Set fechaSolicitud
     *
     * @param \DateTime $fechaSolicitud
     * @return DocmanSolicitud
     */
    public function setFechaSolicitud($fechaSolicitud)
    {
        $this->fechaSolicitud = $fechaSolicitud;

        return $this;
    }

    /**
     * Get fechaSolicitud
     *
     * @return \DateTime 
     */
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    /**
     * Set fechaSolucion
     *
     * @param \DateTime $fechaSolucion
     * @return DocmanSolicitud
     */
    public function setFechaSolucion($fechaSolucion)
    {
        $this->fechaSolucion = $fechaSolucion;

        return $this;
    }

    /**
     * Get fechaSolucion
     *
     * @return \DateTime 
     */
    public function getFechaSolucion()
    {
        return $this->fechaSolucion;
    }

    /**
     * Set derivado
     *
     * @param string $derivado
     * @return DocmanSolicitud
     */
    public function setDerivado($derivado)
    {
        $this->derivado = $derivado;

        return $this;
    }

    /**
     * Get derivado
     *
     * @return string 
     */
    public function getDerivado()
    {
        return $this->derivado;
    }

    /**
     * Set problema
     *
     * @param \Support\SupportBundle\Entity\DocmanProblema $problema
     * @return DocmanSolicitud
     */
    public function setProblema(\Support\SupportBundle\Entity\DocmanProblema $problema = null)
    {
        $this->problema = $problema;

        return $this;
    }

    /**
     * Get problema
     *
     * @return \Support\SupportBundle\Entity\DocmanProblema 
     */
    public function getProblema()
    {
        return $this->problema;
    }

    /**
     * Set solicitante
     *
     * @param \Support\SupportBundle\Entity\DocmanUser $solicitante
     * @return DocmanSolicitud
     */
    public function setSolicitante(\Support\SupportBundle\Entity\DocmanUser $solicitante = null)
    {
        $this->solicitante = $solicitante;

        return $this;
    }

    /**
     * Get solicitante
     *
     * @return \Support\SupportBundle\Entity\DocmanUser 
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Set soporte
     *
     * @param \Support\SupportBundle\Entity\DocmanUser $soporte
     * @return DocmanSolicitud
     */
    public function setSoporte(\Support\SupportBundle\Entity\DocmanUser $soporte = null)
    {
        $this->soporte = $soporte;

        return $this;
    }

    /**
     * Get soporte
     *
     * @return \Support\SupportBundle\Entity\DocmanUser 
     */
    public function getSoporte()
    {
        return $this->soporte;
    }
}
