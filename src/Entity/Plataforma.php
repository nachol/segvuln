<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlataformaRepository")
 */
class Plataforma
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $ubicacion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Escaneo", mappedBy="plataforma", orphanRemoval=true)
     */
    private $escaneos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Responsable", inversedBy="plataformas")
     * @ORM\JoinColumn(nullable=true)
     */
    private $responsable;

    public function __construct()
    {
        $this->escaneos = new ArrayCollection();
    }

    /**
     * @return Collection|Product[]
     */
    public function getEscaneos()
    {
        return $this->escaneos;
    }

    public function removeEscaneo(Escaneo $escaneo)
    {
        $this->escaneos->removeElement($escaneo);
        // set the owning side to null
        $escaneo->setPlataforma(null);
    }

    public function addEscaneo(Escaneo $escaneo)
    {

        if ($this->escaneo->contains($escaneo)) {
            return;
        }

        $this->escaneos[] = $escaneo;

        $escaneo->setPlataforma($this);
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
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * @param mixed $ubicacion
     *
     * @return self
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param mixed $responsable
     *
     * @return self
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function __toString()
    {
        
        return $this->descripcion;
    }
}
