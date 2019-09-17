<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LieuxRepository")
 */
abstract class Lieux
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nombre de nourriture dispo pour la chasse
     * @ORM\Column(type="integer")
     */
    private $nourritureChasse;

    /**
     * Nombre de nourriture dispo pour la cueillette
     * @ORM\Column(type="integer")
     */
    private $nourritureCueillir;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personnage", inversedBy="lieuxConnus")
     */
    private $personnage;

    /**
     * Lieux constructor.
     * @param $nourritureChasse
     * @param $nourritureCueillir
     * @param $personnage
     */
    public function __construct($nourritureChasse, $nourritureCueillir, $personnage)
    {
        $this->nourritureChasse = $nourritureChasse;
        $this->nourritureCueillir = $nourritureCueillir;
        $this->personnage = $personnage;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNourritureChasse(): ?int
    {
        return $this->nourritureChasse;
    }

    public function setNourritureChasse(int $nourritureChasse): self
    {
        $this->nourritureChasse = $nourritureChasse;

        return $this;
    }

    public function getNourritureCueillir(): ?int
    {
        return $this->nourritureCueillir;
    }

    public function setNourritureCueillir(int $nourritureCueillir): self
    {
        $this->nourritureCueillir = $nourritureCueillir;

        return $this;
    }

    public function getPersonnage(): ?Personnage
    {
        return $this->personnage;
    }

    public function setPersonnage(?Personnage $personnage): self
    {
        $this->personnage = $personnage;

        return $this;
    }

//    *****************************************************
    abstract public function etreCueilli();
    abstract public function etreChasser();
    abstract public function etreExplorer();


}
