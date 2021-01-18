<?php

namespace App\Entity;

use App\Repository\ProjetsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetsRepository::class)
 */
class Projets
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
    private $nomProjet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $priorite;

    /**
     * @ORM\Column(type="array")
     */
    private $competence;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreRessorces;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau_competences;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): self
    {
        $this->nomProjet = $nomProjet;

        return $this;
    }

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(string $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }

   

    public function getNombreRessorces(): ?int
    {
        return $this->nombreRessorces;
    }

    public function setNombreRessorces(int $nombreRessorces): self
    {
        $this->nombreRessorces = $nombreRessorces;

        return $this;
    }

    

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCompetence(): ?array
    {
        return $this->competence;
    }

    public function setCompetence(array $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    public function getNiveauCompetences(): ?string
    {
        return $this->niveau_competences;
    }

    public function setNiveauCompetences(string $niveau_competences): self
    {
        $this->niveau_competences = $niveau_competences;

        return $this;
    }
}
