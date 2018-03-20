<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CyberthreatsRepository")
 */
class Cyberthreats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $referencia;

    /**
     * @ORM\Column(type="integer")
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
     * @Assert\DateTime()
     */
    private $deteccion;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"default"=null})
     * @Assert\DateTime()
     */
    private $notificacion;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"default"=null})
     * @Assert\DateTime()
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $observaciones;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * @param mixed $referencia
     *
     * @return self
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     *
     * @return self
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRiesgo()
    {
        return $this->riesgo;
    }

    /**
     * @param mixed $riesgo
     *
     * @return self
     */
    public function setRiesgo($riesgo)
    {
        $this->riesgo = $riesgo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeteccion()
    {
        return $this->deteccion;
    }

    /**
     * @param mixed $deteccion
     *
     * @return self
     */
    public function setDeteccion($deteccion)
    {
        $this->deteccion = $deteccion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotificacion()
    {
        return $this->notificacion;
    }

    /**
     * @param mixed $notificacion
     *
     * @return self
     */
    public function setNotificacion($notificacion)
    {
        $this->notificacion = $notificacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCierre()
    {
        return $this->cierre;
    }

    /**
     * @param mixed $cierre
     *
     * @return self
     */
    public function setCierre($cierre)
    {
        $this->cierre = $cierre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     *
     * @return self
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param mixed $observaciones
     *
     * @return self
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

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
