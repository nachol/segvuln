<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EscaneoRepository")
 */
class Escaneo
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $informe;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vulnerabilidad", mappedBy="escaneo", orphanRemoval=true, fetch="EAGER", cascade={"persist"})
     */
    private $vulnerabilidades;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoEscaneo", inversedBy="escaneos", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plataforma", inversedBy="escaneos", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plataforma;

    public function __construct()
    {
        $this->vulnerabilidades = new ArrayCollection();
    }

    /**
     * @return Collection|Product[]
     */
    public function getVulnerabilidades()
    {
        return $this->vulnerabilidades;
    }

    public function removeVulnerabilidad(Vulnerabilidad $vulnerabilidad)
    {
        $this->vulnerabilidades->removeElement($vulnerabilidad);
        // set the owning side to null
        // $vulnerabilidad->setEscaneo(null);
    }

    public function addVulnerabilidad(Vulnerabilidad $vulnerabilidad)
    {

        if ($this->vulnerabilidades->contains($vulnerabilidad)) {
            return;
        }

        $this->vulnerabilidades->add($vulnerabilidad);

        $vulnerabilidad->setEscaneo($this);
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

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo(TipoEscaneo $tipo)
    {
        $this->tipo = $tipo;
    }

    public function getPlataforma()
    {
        return $this->plataforma;
    }

    public function setPlataforma(Plataforma $plataforma)
    {
        $this->plataforma = $plataforma;
    }
}
