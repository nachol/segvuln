<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResponsableRepository")
 */
class Responsable
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
    private $nombre;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $area;

    /**
     * @ORM\Column(type="string")
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $mail;

    /**
     * @ORM\Column(type="string", nullable=true)
	 */
    private $tel;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $usuarioRed;

     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plataforma", mappedBy="responsable")
     */
    private $plataformas;

    public function __construct()
    {
        $this->plataformas = new ArrayCollection();
    }

    /**
     * @return Collection|Product[]
     */
    public function getPlataformas()
    {
        return $this->plataformas;
    }

    public function removePlataforma(Plataforma $plataforma)
    {
        $this->plataformas->removeElement($plataforma);
        // set the owning side to null
        $plataforma->setResponsable(null);
    }

    public function addPlataforma(Plataforma $plataforma)
    {

        if ($this->plataformas->contains($plataforma)) {
            return;
        }

        $this->plataformas[] = $plataforma;

        $plataforma->setResponsable($this);
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
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     *
     * @return self
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     *
     * @return self
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuarioRed()
    {
        return $this->usuarioRed;
    }

    /**
     * @param mixed $usuarioRed
     *
     * @return self
     */
    public function setUsuarioRed($usuarioRed)
    {
        $this->usuarioRed = $usuarioRed;

        return $this;
    }

        /**
     * @return mixed
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param mixed $apellido
     *
     * @return self
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param mixed $area
     *
     * @return self
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    public function __toString()
    {
        
        return $this->apellido . ", " . $this->nombre;
    }
}
