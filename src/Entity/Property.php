<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $namePlace = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $acquisitionDate = null;

    #[ORM\Column(nullable: true)]
    private ?float $acquisitionPrice = null;

    #[ORM\Column(nullable: true)]
    private ?float $acquisitionFee = null;

    #[ORM\Column(nullable: true)]
    private ?float $agencyFee = null;

    #[ORM\Column(nullable: true)]
    private ?float $propertyValue = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    private ?User $user = null;

    /**
     * @var Collection<int, PropertyImage>
     */
    #[ORM\OneToMany(targetEntity: PropertyImage::class, mappedBy: 'property')]
    private Collection $propertyImages;

    /**
     * @var Collection<int, Description>
     */
    #[ORM\OneToMany(targetEntity: Description::class, mappedBy: 'property')]
    private Collection $descriptions;

    /**
     * @var Collection<int, Tax>
     */
    #[ORM\OneToMany(targetEntity: Tax::class, mappedBy: 'property')]
    private Collection $taxes;

    /**
     * @var Collection<int, LandRegistry>
     */
    #[ORM\OneToMany(targetEntity: LandRegistry::class, mappedBy: 'property')]
    private Collection $landRegistries;

    /**
     * @var Collection<int, PropertyDocument>
     */
    #[ORM\OneToMany(targetEntity: PropertyDocument::class, mappedBy: 'property')]
    private Collection $propertyDocuments;

    /**
     * @var Collection<int, Rental>
     */
    #[ORM\OneToMany(targetEntity: Rental::class, mappedBy: 'property')]
    private Collection $Rentals;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    private ?Address $address = null;

    public function __construct()
    {
        $this->propertyImages = new ArrayCollection();
        $this->descriptions = new ArrayCollection();
        $this->taxes = new ArrayCollection();
        $this->landRegistries = new ArrayCollection();
        $this->propertyDocuments = new ArrayCollection();
        $this->Rentals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getNamePlace(): ?string
    {
        return $this->namePlace;
    }

    public function setNamePlace(?string $namePlace): static
    {
        $this->namePlace = $namePlace;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getAcquisitionDate(): ?\DateTimeInterface
    {
        return $this->acquisitionDate;
    }

    public function setAcquisitionDate(?\DateTimeInterface $acquisitionDate): static
    {
        $this->acquisitionDate = $acquisitionDate;

        return $this;
    }

    public function getAcquisitionPrice(): ?float
    {
        return $this->acquisitionPrice;
    }

    public function setAcquisitionPrice(?float $acquisitionPrice): static
    {
        $this->acquisitionPrice = $acquisitionPrice;

        return $this;
    }

    public function getAcquisitionFee(): ?float
    {
        return $this->acquisitionFee;
    }

    public function setAcquisitionFee(?float $acquisitionFee): static
    {
        $this->acquisitionFee = $acquisitionFee;

        return $this;
    }

    public function getAgencyFee(): ?float
    {
        return $this->agencyFee;
    }

    public function setAgencyFee(?float $agencyFee): static
    {
        $this->agencyFee = $agencyFee;

        return $this;
    }

    public function getPropertyValue(): ?float
    {
        return $this->propertyValue;
    }

    public function setPropertyValue(?float $propertyValue): static
    {
        $this->propertyValue = $propertyValue;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, propertyImage>
     */
    public function getPropertyImages(): Collection
    {
        return $this->propertyImages;
    }

    public function addPropertyImage(propertyImage $propertyImage): static
    {
        if (!$this->propertyImages->contains($propertyImage)) {
            $this->propertyImages->add($propertyImage);
            $propertyImage->setProperty($this);
        }

        return $this;
    }

    public function removePropertyImage(propertyImage $propertyImage): static
    {
        if ($this->propertyImages->removeElement($propertyImage)) {
            // set the owning side to null (unless already changed)
            if ($propertyImage->getProperty() === $this) {
                $propertyImage->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Description>
     */
    public function getDescriptions(): Collection
    {
        return $this->descriptions;
    }

    public function addDescription(Description $description): static
    {
        if (!$this->descriptions->contains($description)) {
            $this->descriptions->add($description);
            $description->setProperty($this);
        }

        return $this;
    }

    public function removeDescription(Description $description): static
    {
        if ($this->descriptions->removeElement($description)) {
            // set the owning side to null (unless already changed)
            if ($description->getProperty() === $this) {
                $description->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, tax>
     */
    public function getTaxes(): Collection
    {
        return $this->taxes;
    }

    public function addTax(tax $tax): static
    {
        if (!$this->taxes->contains($tax)) {
            $this->taxes->add($tax);
            $tax->setProperty($this);
        }

        return $this;
    }

    public function removeTax(tax $tax): static
    {
        if ($this->taxes->removeElement($tax)) {
            // set the owning side to null (unless already changed)
            if ($tax->getProperty() === $this) {
                $tax->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, landRegistry>
     */
    public function getLandRegistries(): Collection
    {
        return $this->landRegistries;
    }

    public function addLandRegistry(landRegistry $landRegistry): static
    {
        if (!$this->landRegistries->contains($landRegistry)) {
            $this->landRegistries->add($landRegistry);
            $landRegistry->setProperty($this);
        }

        return $this;
    }

    public function removeLandRegistry(landRegistry $landRegistry): static
    {
        if ($this->landRegistries->removeElement($landRegistry)) {
            // set the owning side to null (unless already changed)
            if ($landRegistry->getProperty() === $this) {
                $landRegistry->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, propertyDocument>
     */
    public function getPropertyDocuments(): Collection
    {
        return $this->propertyDocuments;
    }

    public function addPropertyDocument(propertyDocument $propertyDocument): static
    {
        if (!$this->propertyDocuments->contains($propertyDocument)) {
            $this->propertyDocuments->add($propertyDocument);
            $propertyDocument->setProperty($this);
        }

        return $this;
    }

    public function removePropertyDocument(propertyDocument $propertyDocument): static
    {
        if ($this->propertyDocuments->removeElement($propertyDocument)) {
            // set the owning side to null (unless already changed)
            if ($propertyDocument->getProperty() === $this) {
                $propertyDocument->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rental>
     */
    public function getRentals(): Collection
    {
        return $this->Rentals;
    }

    public function addRental(Rental $rental): static
    {
        if (!$this->Rentals->contains($rental)) {
            $this->Rentals->add($rental);
            $rental->setProperty($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): static
    {
        if ($this->Rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getProperty() === $this) {
                $rental->setProperty(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }
}
