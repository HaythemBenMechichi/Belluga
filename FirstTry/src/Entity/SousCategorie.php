<?php

namespace App\Entity;

use App\Repository\SousCategorieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SousCategorieRepository::class)
 */
class SousCategorie
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
    private $nomSous;

    /**
     * @ORM\Column(type="integer")
     */
    private $StatSC;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="idSousCategorie")
     */
    private $idCat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSous(): ?string
    {
        return $this->nomSous;
    }

    public function setNomSous(string $nomSous): self
    {
        $this->nomSous = $nomSous;

        return $this;
    }

    public function getStatSC(): ?int
    {
        return $this->StatSC;
    }

    public function setStatSC(int $StatSC): self
    {
        $this->StatSC = $StatSC;

        return $this;
    }

    public function getIdCat(): ?Categorie
    {
        return $this->idCat;
    }

    public function setIdCat(?Categorie $idCat): self
    {
        $this->idCat = $idCat;

        return $this;
    }

    public function __toString()
    {
        return $this->nomSous;
    }

}
