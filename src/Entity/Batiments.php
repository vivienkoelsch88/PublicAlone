<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BatimentsRepository")
 */
abstract class Batiments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Ressources nécessaires à la construction
     * @ORM\OneToMany(targetEntity="App\Entity\Ressources", mappedBy="batiments")
     */
    private $RessourcesNecessaires;

    /**
     * Le camp si ce bâtiment est construit
     * @ORM\ManyToOne(targetEntity="App\Entity\Camp", inversedBy="listeBatiments")
     */
    private $camp;

    /**
     * Le camp si ce bâtiment est connu
     * @ORM\ManyToOne(targetEntity="App\Entity\Camp", inversedBy="listedebatimentsconnus")
     */
    private $campConnu;

    public function __construct()
    {
//        A ajouter dans les param quand enfant
        $this->RessourcesNecessaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Ressources[]
     */
    public function getRessourcesNecessaires(): Collection
    {
        return $this->RessourcesNecessaires;
    }

    public function addRessourcesNecessaire(Ressources $ressourcesNecessaire): self
    {
        if (!$this->RessourcesNecessaires->contains($ressourcesNecessaire)) {
            $this->RessourcesNecessaires[] = $ressourcesNecessaire;
            $ressourcesNecessaire->setBatiments($this);
        }

        return $this;
    }

    public function removeRessourcesNecessaire(Ressources $ressourcesNecessaire): self
    {
        if ($this->RessourcesNecessaires->contains($ressourcesNecessaire)) {
            $this->RessourcesNecessaires->removeElement($ressourcesNecessaire);
            if ($ressourcesNecessaire->getBatiments() === $this) {
                $ressourcesNecessaire->setBatiments(null);
            }
        }

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

    public function getCampConnu(): ?Camp
    {
        return $this->campConnu;
    }

    public function setCampConnu(?Camp $campConnu): self
    {
        $this->campConnu = $campConnu;

        return $this;
    }
//    ******************************************************
    abstract public function detruire();
    abstract public function effetconstruction();



}
