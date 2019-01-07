<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 14
     * )
    'Activismo' => 0,
    'Exposición de Información' => 1,
    'Hacktivismo' => 2,
    'Vulneración Mecanismos Seguridad' => 3,
    'CVEs & Boletín de Seguridad' => 4,
    'Robo de Credenciales' => 5,
    'Uso No Autorizado de Marca' => 6,
    'Dominios Sospechosos' => 7,
    'Contenidos Ofensivos' => 8,
    'Counterfeit' => 9,
    'Seguimiento Identidad Digital' => 10,
    'Phishing y Pharming' => 11,
    'Malware' => 12,
    'Carding' => 13,
    'Apps Móviles Sospechosas' => 14
     */
    private $tipo;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 3
     * )
     * 0-Bajo, 1-Medio, 2-Alto, 3-Muy Alto
     */
    private $riesgo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $deteccion;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"default"=null})
     */
    private $notificacion;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"default"=null})
     */
    private $cierre;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 1
     * )
     * 0-Pendiente, 1-Cerrado
     */
    private $estado;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default"=0})
     * @Assert\Range(
     *      min = 0,
     *      max = 1
     * )
     * 0-Otro, 1-Investigacion
     */
    private $investigacion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $referente;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    public function setTipo(?int $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getRiesgo(): ?int
    {
        return $this->riesgo;
    }

    public function setRiesgo(int $riesgo): self
    {
        $this->riesgo = $riesgo;

        return $this;
    }

    public function getDeteccion(): ?\DateTimeInterface
    {
        return $this->deteccion;
    }

    public function setDeteccion(\DateTimeInterface $deteccion): self
    {
        $this->deteccion = $deteccion;

        return $this;
    }

    public function getNotificacion(): ?\DateTimeInterface
    {
        return $this->notificacion;
    }

    public function setNotificacion(?\DateTimeInterface $notificacion): self
    {
        $this->notificacion = $notificacion;

        return $this;
    }

    public function getCierre(): ?\DateTimeInterface
    {
        return $this->cierre;
    }

    public function setCierre(?\DateTimeInterface $cierre): self
    {
        $this->cierre = $cierre;

        return $this;
    }

    public function getEstado(): ?int
    {
        return $this->estado;
    }

    public function setEstado(int $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getInvestigacion(): ?int
    {
        return $this->investigacion;
    }

    public function setInvestigacion(int $investigacion): self
    {
        $this->investigacion = $investigacion;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getReferente(): ?string
    {
        return $this->referente;
    }

    public function setReferente(string $referente): self
    {
        $this->referente = $referente;

        return $this;
    }

    /**
     * @param mixed $riesgo
     *
     * @return self
     */
    public function getStringRiesgo()
    {
        switch ($this->riesgo) {
            case 0:
                return "BAJO";
                break;
            case 1:
                return "MEDIO";
                break;
            case 2:
                return "ALTO";
                break;
            case 3:
                return "MUY ALTO";
                break;
            default:
                
                break;
        }
        return "N/A";
    }

    /**
     * @param mixed $riesgo
     *
     * @return self
     */
    public function getStringEstado()
    {
        switch ($this->estado) {
            case 0:
                return "Pendiente";
                break;
            case 1:
                return "Cerrado";
                break;
            default:                
                break;
        }
        return "N/A";
    }

    /**
     * @param mixed $riesgo
     *
     * @return self
     */
    public function getStringTipo()
    {
        switch ($this->tipo) {
            case 0:
                return "Activismo";
                break;
            case 1:
                return "Exposición de Información";
                break;
            case 2:
                return "Hacktivismo";
                break;
            case 3:
                return "Vulneración Mecanismos Seguridad";
                break;
            case 4:
                return "CVEs & Boletín de Seguridad";
                break;
            case 5:
                return "Robo de Credenciales";
                break;
            case 6:
                return "Uso No Autorizado de Marca";
                break;
            case 7:
                return "Dominios Sospechosos";
                break;
            case 8:
                return "Contenidos Ofensivos";
                break;
            case 9:
                return "Counterfeit";
                break;
            case 10:
                return "Seguimiento Identidad Digital";
                break;
            case 11:
                return "Phishing y Pharming";
                break;
            case 12:
                return "Malware";
                break;
            case 13:
                return "Carding";
                break;
            case 14:
                return "Apps Móviles Sospechosas";
                break;
            default:                
                break;
        }
        return "N/A";
    }

    /**
     * @param mixed $observaciones
     *
     * @return self
     */
    public function getDias()
    {
        if($this->cierre != null && $this->notificacion != null){
            return $this->notificacion->diff($this->cierre)->format('%a');
        }
    }

    /**
     * @Assert\IsTrue(message="Falta fecha de cierre para el estado cerrado")
     */
    public function isCierreValid()
    {
        if($this->estado == 1 and $this->cierre == null){
            return false;
        }
        return true;
    }
}
