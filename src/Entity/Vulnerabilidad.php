<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VulnerabilidadRepository")
 */
class Vulnerabilidad
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", options={"default":1})
     * @Assert\Range(
     *      min = 0,
     *      max = 2
     * )
     * 0-Inactivo, 1-Activo, 2-Aceptado
     */
    private $estado;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fechaModificacion;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoVuln", inversedBy="vulnerabilidades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipo;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Escaneo", inversedBy="vulnerabilidades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $escaneo;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $ip;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $port;

    private $cantidad;

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
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * @param mixed $fechaCreacion
     *
     * @return self
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }


    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo(TipoVuln $tipo)
    {
        $this->tipo = $tipo;
    }

    public function getEscaneo()
    {
        return $this->escaneo;
    }

    public function setEscaneo(Escaneo $escaneo)
    {
        $this->escaneo = $escaneo;
    }

    /**
     * @return mixed
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * @param mixed $fechaModificacion
     *
     * @return self
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $fechaModificacion
     *
     * @return self
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $fechaModificacion
     *
     * @return self
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $fechaModificacion
     *
     * @return self
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }


        /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $fechaModificacion
     *
     * @return self
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * @param mixed $criticidad
     *
     * @return self
     */
    public function getStringEstado()
    {
        switch ($this->estado) {
            case 0:
                return "Remediada";
                break;
            case 1:
                return "Activa";
                break;
            case 2:
                return "Asumida";
                break;
            default:
                
                break;
        }
        return "N/A";
    }
}
