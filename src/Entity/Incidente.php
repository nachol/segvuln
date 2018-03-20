<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass="App\Repository\IncidenteRepository")
 */
class Incidente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $fecha;

    /**
     * @ORM\Column(type="string")
     */
    private $nombre;

	/**
     * @ORM\Column(type="string")
     */
    private $ticket;

    /**
     * @ORM\Column(type="boolean")
     */
    private $informe;

    /**
     * @ORM\Column(type="string")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="boolean")
     'Cerrado' => true,
     'Pendiente' => false,
     */
    private $estado;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $cierre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentario", mappedBy="incidente", orphanRemoval=true, fetch="EAGER", cascade={"persist"})
     */
    private $comentarios;

    public function __construct()
    {
        $this->comentarios = new ArrayCollection();
    }


    /**
     * @return Collection|Product[]
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    public function removeComentario(Comentario $cometario)
    {
        $this->comentarios->removeElement($comentario);
        // set the owning side to null
        // $vulnerabilidad->setEscaneo(null);
    }

    public function addComentario(Comentario $cometario)
    {

        if ($this->comentarios->contains($comentario)) {
            return;
        }

        $this->comentarios->add($comentario);

        $comentario->setIncidente($this);
    }

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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     *
     * @return self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     *
     * @return self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param mixed $ticket
     *
     * @return self
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInforme()
    {
        return $this->informe;
    }

    /**
     * @param mixed $informe
     *
     * @return self
     */
    public function setInforme($informe)
    {
        $this->informe = $informe;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     *
     * @return self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

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
    public function getStringEstado()
    {
        switch ($this->estado) {
            case true:
                return "Cerrado";
                break;
            case false:
                return "Pendiente";
                break;
            default:                
                break;
        }
        return "N/A";
    }

    /**
     * @return mixed
     */
    public function getStringInforme()
    {
        switch ($this->informe) {
            case true:
                return "Si";
                break;
            case false:
                return "No";
                break;
            default:                
                break;
        }
        return "N/A";
    }
}
