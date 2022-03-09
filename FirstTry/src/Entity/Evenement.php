<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;




/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("events")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime",nullable=false)
     * @Assert\NotNull(message="est")
     * @Assert\LessThan(propertyPath="DateFin", message="La date de début est invalide")
     * @Groups("events")
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="datetime",nullable=false)
     * @Assert\GreaterThan(propertyPath="datedebut",message="Vérifiez la date")
     * @Groups("events")
     */
    private $DateFin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     * @Assert\Length(min=3)
     * @Groups("events")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("events")
     *
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=EventProd::class, mappedBy="evenement")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")

     */
    private $event;

    public function __construct()
    {
        $this->event = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut=null): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin=null): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|EventProd[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(EventProd $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
            $event->setEvenement($this);
        }

        return $this;
    }

    public function removeEvent(EventProd $event): self
    {
        if ($this->event->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getEvenement() === $this) {
                $event->setEvenement(null);
            }
        }

        return $this;
    }
}
