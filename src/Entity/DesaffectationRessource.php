<?php

namespace App\Entity;

use App\Repository\DesaffectationRessourceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DesaffectationRessourceRepository::class)
 */
class DesaffectationRessource
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Ressource;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Projet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mois;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRessource(): ?string
    {
        return $this->Ressource;
    }

    public function setRessource(string $Ressource): self
    {
        $this->Ressource = $Ressource;

        return $this;
    }

    public function getProjet(): ?string
    {
        return $this->Projet;
    }

    public function setProjet(string $Projet): self
    {
        $this->Projet = $Projet;

        return $this;
    }

    public function getMois(): ?string
    {
        return $this->Mois;
    }

    public function setMois(string $Mois): self
    {
        $this->Mois = $Mois;

        return $this;
    }
}
