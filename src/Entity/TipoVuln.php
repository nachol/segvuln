<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TipoVulnRepository")
 */
class TipoVuln
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
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 2
     * )
     * 0-Critica, 1-Alta, 2-Media
     */
    private $criticidad;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vulnerabilidad", mappedBy="tipo", orphanRemoval=true)
     */
    private $vulnerabilidades;


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

    public function addVulnerabilidad(Vulnerabilidad $vulnerabilidad)
    {

        if ($this->vulnerabilidades->contains($vulnerabilidad)) {
            return;
        }

        $this->vulnerabilidades[] = $vulnerabilidad;

        $vulnerabilidad->setTipo($this);
    }

    public function removeVulnerabilidad(Vulnerabilidad $vulnerabilidad)
    {
        $this->vulnerabilidades->removeElement($vulnerabilidad);
        // set the owning side to null
        $vulnerabilidad->setTipo(null);
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
    public function getCriticidad()
    {
        return $this->criticidad;
    }

    /**
     * @param mixed $criticidad
     *
     * @return self
     */
    public function setCriticidad($criticidad)
    {
        $this->criticidad = $criticidad;

        return $this;
    }


    /**
     * @param mixed $criticidad
     *
     * @return self
     */
    public function getStringCriticidad()
    {
        switch ($this->criticidad) {
            case 0:
                return "Crítica";
                break;
            case 1:
                return "Alta";
                break;
            case 2:
                return "Media";
                break;
            default:
                
                break;
        }
        return "N/A";
    }
}
