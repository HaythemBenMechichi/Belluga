<?php

namespace App\Entity;

use App\Repository\EventProdRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventProdRepository::class)
 */
class EventProd
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $refProd;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="event")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    private $evenement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomProduit;

    /**
     * @ORM\Column(type="float")
     */
    private $taux;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefProd(): ?int
    {
        return $this->refProd;
    }

    public function setRefProd(int $refProd): self
    {
        $this->refProd = $refProd;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }

    public function getNomProduit(): ?string
    {
        return $this->NomProduit;
    }

    public function setNomProduit(string $NomProduit): self
    {
        $this->NomProduit = $NomProduit;

        return $this;
    }

    public function getTaux(): ?float
    {
        return $this->taux;
    }

    public function setTaux(float $taux): self
    {
        $this->taux = $taux;

        return $this;
    }
}
