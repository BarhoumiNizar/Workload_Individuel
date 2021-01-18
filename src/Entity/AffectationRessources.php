<?php

namespace App\Entity;

use App\Repository\AffectationRessourcesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AffectationRessourcesRepository::class)
 */
class AffectationRessources
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Ressources")
     */
    private $Ressource;

    /**
     * @ORM\Column(type="array")
     */
    private $Projet;

    /**
     * @ORM\Column(type="array")
     */
    private $Mois;

    /**
     * @ORM\Column(type="array")
     */
    private $pourcentage;

    
    public function getId(): ?int
    {
        return $this->id;
    }

     public function getRessource(): ?Ressources
    {
        return $this->Ressource;
    }

    public function setRessource(?Ressources $Ressource): self
    {
        $this->Ressource = $Ressource;

        return $this;
    }

    public function getMois(): ?array
    {
        return $this->Mois;
    }

    public function setMois(array $Mois): self
    {
        $this->Mois = $Mois;

        return $this;
    }

    public function getPourcentage(): ?array
    {
        return $this->pourcentage;
    }

    public function setPourcentage(array $pourcentage): self
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getProjet(): ?array
    {
        return $this->Projet;
    }

    public function setProjet(array $Projet): self
    {
        $this->Projet = $Projet;

        return $this;
    }
}
