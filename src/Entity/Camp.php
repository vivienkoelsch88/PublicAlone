<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampRepository")
 */
class Camp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Liste des ressources disponibles
     * @ORM\OneToMany(targetEntity="App\Entity\Ressources", mappedBy="camp")
     */
    private $listeRessource;

    /**
     * Liste des bâtiments du camp
     * @ORM\OneToMany(targetEntity="App\Entity\Batiments", mappedBy="camp")
     */
    private $listeBatiments;

    /**
     * Liste des bâtiments connus par le joueur et dispo à la construction
     * @ORM\OneToMany(targetEntity="App\Entity\Batiments", mappedBy="campConnu")
     */
    private $listedebatimentsconnus;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Personnage", mappedBy="camp", cascade={"persist", "remove"})
     */
    private $personnage;

    public function __construct()
    {
        $this->listeRessource = new ArrayCollection();
        $this->listeBatiments = new ArrayCollection();
        $this->listedebatimentsconnus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Ressources[]
     */
    public function getListeRessource(): Collection
    {
        return $this->listeRessource;
    }

    public function addListeRessource(Ressources $listeRessource): self
    {
        if (!$this->listeRessource->contains($listeRessource)) {
            $this->listeRessource[] = $listeRessource;
            $listeRessource->setCamp($this);
        }

        return $this;
    }

    public function removeListeRessource(Ressources $listeRessource): self
    {
        if ($this->listeRessource->contains($listeRessource)) {
            $this->listeRessource->removeElement($listeRessource);
            if ($listeRessource->getCamp() === $this) {
                $listeRessource->setCamp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Batiments[]
     */
    public function getListeBatiments(): Collection
    {
        return $this->listeBatiments;
    }

    public function addListeBatiment(Batiments $listeBatiment): self
    {
        if (!$this->listeBatiments->contains($listeBatiment)) {
            $this->listeBatiments[] = $listeBatiment;
            $listeBatiment->setCamp($this);
        }

        return $this;
    }

    public function removeListeBatiment(Batiments $listeBatiment): self
    {
        if ($this->listeBatiments->contains($listeBatiment)) {
            $this->listeBatiments->removeElement($listeBatiment);
            if ($listeBatiment->getCamp() === $this) {
                $listeBatiment->setCamp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Batiments[]
     */
    public function getListedebatimentsconnus(): Collection
    {
        return $this->listedebatimentsconnus;
    }

    public function addListedebatimentsconnus(Batiments $listedebatimentsconnus): self
    {
        if (!$this->listedebatimentsconnus->contains($listedebatimentsconnus)) {
            $this->listedebatimentsconnus[] = $listedebatimentsconnus;
            $listedebatimentsconnus->setCampConnu($this);
        }

        return $this;
    }

    public function removeListedebatimentsconnus(Batiments $listedebatimentsconnus): self
    {
        if ($this->listedebatimentsconnus->contains($listedebatimentsconnus)) {
            $this->listedebatimentsconnus->removeElement($listedebatimentsconnus);
            if ($listedebatimentsconnus->getCampConnu() === $this) {
                $listedebatimentsconnus->setCampConnu(null);
            }
        }

        return $this;
    }

    public function getPersonnage(): ?Personnage
    {
        return $this->personnage;
    }

    public function setPersonnage(?Personnage $personnage): self
    {
        $this->personnage = $personnage;
        $newCamp = $personnage === null ? null : $this;
        if ($newCamp !== $personnage->getCamp()) {
            $personnage->setCamp($newCamp);
        }

        return $this;
    }

//    *************************************************
    public function construire(Batiments $batiment){
        if($this->getListedebatimentsconnus()->contains($batiment)){
            $this->addListeBatiment($batiment);

            foreach ($batiment->getRessourcesNecessaires() as $ressources){
                foreach ($this->getListeRessource() as $ressourceDispo){
                    if($ressourceDispo->getType() === $ressources->getType()){
                        $ressourceDispo->setNombre($ressourceDispo->getNombre() - $ressources->getNombre());
                    }
                }
            }
            $batiment->effetconstruction();
        }
    }
}
