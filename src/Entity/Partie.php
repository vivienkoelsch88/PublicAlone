<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartieRepository")
 */
class Partie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="parties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Personnage", mappedBy="Partie", cascade={"persist", "remove"})
     */
    private $personnage;

    /**
     * Partie constructor.
     * @param $User
     */
    public function __construct(User $User)
    {
        $this->User = $User;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getPersonnage(): ?Personnage
    {
        return $this->personnage;
    }

    public function setPersonnage(Personnage $personnage): self
    {
        $this->personnage = $personnage;

        if ($this !== $personnage->getPartie()) {
            $personnage->setPartie($this);
        }

        return $this;
    }

}
