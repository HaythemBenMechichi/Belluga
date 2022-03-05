<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    private $NomC;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotNull
     */
    private $statC;

    /**
     * @ORM\OneToMany(targetEntity=SousCategorie::class, mappedBy="idCat")
     * @Assert\NotNull
     */
    private $idSousCategorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageCar;

    public function __construct()
    {
        $this->idSousCategorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomC(): ?string
    {
        return $this->NomC;
    }

    public function setNomC(string $NomC): self
    {
        $this->NomC = $NomC;

        return $this;
    }

    public function getStatC(): ?int
    {
        return $this->statC;
    }

    public function setStatC(?int $statC): self
    {
        $this->statC = $statC;

        return $this;
    }

    /**
     * @return Collection|SousCategorie[]
     */
    public function getIdSousCategorie(): Collection
    {
        return $this->idSousCategorie;
    }

    public function addIdSousCategorie(SousCategorie $idSousCategorie): self
    {
        if (!$this->idSousCategorie->contains($idSousCategorie)) {
            $this->idSousCategorie[] = $idSousCategorie;
            $idSousCategorie->setIdCat($this);
        }

        return $this;
    }

    public function removeIdSousCategorie(SousCategorie $idSousCategorie): self
    {
        if ($this->idSousCategorie->removeElement($idSousCategorie)) {
            // set the owning side to null (unless already changed)
            if ($idSousCategorie->getIdCat() === $this) {
                $idSousCategorie->setIdCat(null);
            }
        }

        return $this;
    }

    public function getImageCar(): ?string
    {
        return $this->imageCar;
    }

    public function setImageCar(string $imageCar): self
    {
        $this->imageCar = $imageCar;

        return $this;
    }
}