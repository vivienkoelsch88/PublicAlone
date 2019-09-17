<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonnageRepository")
 */
class Personnage
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
    private $life;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Partie", inversedBy="personnage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Partie;

    /**
     * Lieux que le joueur a visité
     * @ORM\OneToMany(targetEntity="App\Entity\Lieux", mappedBy="personnage")
     */
    private $lieuxConnus;

    /**
     * @ORM\Column(type="integer")
     */
    private $moral;

    /**
     * @ORM\Column(type="integer")
     */
    private $nourriture;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Lieux", cascade={"persist"})
     */
    private $lieuActuel;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Camp", inversedBy="personnage", cascade={"persist", "remove"})
     */
    private $camp;

    /**
     * Personnage constructor.
     * @param Partie $partie
     * @param Camp $camp
     */
    public function __construct(Partie $partie, Camp $camp )
    {
        $this->life = 100;
        $this->moral = 100;
        $this->nourriture = 2;
        $this->Partie = $partie;
        $this->camp = $camp;
        $this->lieuxConnus = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartie(): ?Partie
    {
        return $this->Partie;
    }

    public function setPartie(Partie $Partie): self
    {
        $this->Partie = $Partie;

        return $this;
    }

    public function getlife(): ?int
    {
        return $this->life;
    }

    public function setlife(int $life): self
    {
        $this->life = $life;
        if($this->life > 100){
            $this->life = 100;
        }
        if($this->life < 0){
            $this->life = 0;
        }

        return $this;
    }

    /**
     * @return Collection|Lieux[]
     */
    public function getLieuxConnus(): Collection
    {
        return $this->lieuxConnus;
    }

    public function addLieuxConnus(Lieux $lieuxConnus): self
    {
        if (!$this->lieuxConnus->contains($lieuxConnus)) {
            $this->lieuxConnus[] = $lieuxConnus;
            $lieuxConnus->setPersonnage($this);
        }

        return $this;
    }

    public function removeLieuxConnus(Lieux $lieuxConnus): self
    {
        if ($this->lieuxConnus->contains($lieuxConnus)) {
            $this->lieuxConnus->removeElement($lieuxConnus);
            if ($lieuxConnus->getPersonnage() === $this) {
                $lieuxConnus->setPersonnage(null);
            }
        }

        return $this;
    }

    public function getMoral(): ?int
    {
        return $this->moral;
    }

    public function setMoral(int $moral): self
    {
        $this->moral = $moral;

        if($this->moral > 100){
            $this->moral = 100;
        }
        if($this->moral < 0){
            $this->moral = 0;
        }
        return $this;
    }

    public function getNourriture(): ?int
    {
        return $this->nourriture;
    }

    public function setNourriture(?int $nourriture): self
    {
        $this->nourriture = $nourriture;
        if($this->nourriture < 0){
            $this->nourriture = 0;
        }

        return $this;
    }

    public function getLieuActuel(): ?Lieux
    {
        return $this->lieuActuel;
    }

    public function setLieuActuel(?Lieux $lieuActuel): self
    {
        $this->lieuActuel = $lieuActuel;

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
//    *************************************************************************

    public function explorer(Lieux $lieux){
        $this->setLieuActuel($lieux);
        $this->addLieuxConnus($lieux);
        $lieux->etreExplorer();
    }

    public function seReposer(){
        $this->setlife($this->getlife() + 50);
        $this->setMoral($this->getMoral() + 50);

    }

    public function chasser(Lieux $lieux){
        $lieux->etreChasser();
    }

    public function cueillir(Lieux $lieux){
        $lieux->etreCueilli();
    }


}
