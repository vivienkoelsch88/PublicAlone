<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RessourcesRepository")
 */
class Ressources
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre;

    /**
     * Le camp si celui-ci contient la ressource
     * @ORM\ManyToOne(targetEntity="App\Entity\Camp", inversedBy="listeRessource")
     */
    private $camp;

    /**
     * Le bâtiment qui a besoin de cette ressource à sa construction
     * @ORM\ManyToOne(targetEntity="App\Entity\Batiments", inversedBy="RessourcesNecessaires")
     */
    private $batiments;

    /**
     * Le type de ressource
     */
    private $type;

    /**
     * Ressources constructor.
     * @param $nombre
     */
    public function __construct($nombre, $type)
    {
        $this->nombre = $nombre;
        $this->type = $type;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCamp(): ?Camp
    {
        return $this->camp;
    }

    public function setCamp(?Camp $camp): self
    {
        $this->camp = $camp;

        return $this;
    }

    public function getBatiments(): ?Batiments
    {
        return $this->batiments;
    }

    public function setBatiments(?Batiments $batiments): self
    {
        $this->batiments = $batiments;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }


}
