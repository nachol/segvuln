<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TipoEscaneoRepository")
 */
class TipoEscaneo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice({"Infraestructura", "Web", "Aplicacion Mobile"})
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Escaneo", mappedBy="tipo", orphanRemoval=true)
     */
    private $escaneos;

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
        $escaneo->setTipo(null);
    }

    public function addEscaneo(Escaneo $escaneo)
    {

        if ($this->escaneos->contains($escaneo)) {
            return;
        }

        $this->escaneos[] = $escaneo;

        $escaneo->setTipo($this);
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

    public function __toString()
    {
        
        return $this->descripcion;
    }
}
