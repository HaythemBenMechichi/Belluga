<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_product", "list_product"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull (message="vous devez saisir le libelle ") 
     * @Groups({"show_product", "list_product"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotNull(message="vous devez saisir la description ")
     * @Groups({"show_product", "list_product"})
     */
    private $Description;

    /**
     * @ORM\Column(type="integer")
     *  @Assert\NotNull(message="vous devez saisir la quantite ")
     * @Groups({"show_product", "list_product"})
     * @Assert\Positive
     */
     
    private $Quantite;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotNull(message="vous devez saisir le prix ")
     * @Groups({"show_product", "list_product"})
     * @Assert\Positive
     */
    private $prix;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_product", "list_product"})
     */

    private $imageP;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategorie::class)
     * @Groups({"list_product"})
     */
    private $idSousCat;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->Quantite;
    }

    public function setQuantite(int $Quantite): self
    {
        $this->Quantite = $Quantite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImageP(): ?string
    {
        return $this->imageP;
    }

    public function setImageP(string $imageP): self
    {
        $this->imageP = $imageP;

        return $this;
    }

    public function getIdSousCat(): ?SousCategorie
    {
        return $this->idSousCat;
    }

    public function setIdSousCat(?SousCategorie $idSousCat): self
    {
        $this->idSousCat = $idSousCat;

        return $this;
    }   
 
    public function __toString()
    {
        return $this->idSousCat;
    }


}
