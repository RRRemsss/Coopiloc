<?php

namespace App\Entity;

use App\Repository\RentalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentalRepository::class)]
class Rental
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 100)]
    private ?string $leaseType = null;

    #[ORM\Column(nullable: true)]
    private ?float $grossRent = null;

    #[ORM\Column]
    private ?float $charge = null;

    #[ORM\Column(nullable: true)]
    private ?float $deposit = null;

    #[ORM\Column]
    private ?float $netRent = null;

    #[ORM\Column(nullable: true)]
    private ?float $housingAssistance = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $purposeUse = null;

    #[ORM\Column(nullable: true)]
    private ?string $duration = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $paymentPeriod = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $paymentMethod = null;

    #[ORM\Column(nullable: true)]
    private ?int $paymentDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $privateComment = null;

    #[ORM\ManyToOne(inversedBy: 'Rentals')]
    private ?Property $property = null;

    /**
     * @var Collection<int, RentalDocument>
     */
    #[ORM\OneToMany(targetEntity: RentalDocument::class, mappedBy: 'rental')]
    private Collection $rentalDocuments;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    /**
     * @var Collection<int, Tenant>
     */
    #[ORM\OneToMany(targetEntity: Tenant::class, mappedBy: 'rental')]
    private Collection $tenants;

    #[ORM\Column(nullable: true)]
    private ?float $garageParkingBoxRent = null;

    public function __construct()
    {
        $this->rentalDocuments = new ArrayCollection();
        $this->tenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getLeaseType(): ?string
    {
        return $this->leaseType;
    }

    public function setLeaseType(string $leaseType): static
    {
        $this->leaseType = $leaseType;

        return $this;
    }

    public function getGrossRent(): ?float
    {
        return $this->grossRent;
    }

    public function setGrossRent(float $grossRent): static
    {
        $this->grossRent = $grossRent;

        return $this;
    }

    public function getCharge(): ?float
    {
        return $this->charge;
    }

    public function setCharge(float $charge): static
    {
        $this->charge = $charge;

        return $this;
    }

    public function getDeposit(): ?float
    {
        return $this->deposit;
    }

    public function setDeposit(?float $deposit): static
    {
        $this->deposit = $deposit;

        return $this;
    }

    public function getNetRent(): ?float
    {
        return $this->netRent;
    }

    public function setNetRent(float $netRent): static
    {
        $this->netRent = $netRent;

        return $this;
    }

    public function getHousingAssistance(): ?float
    {
        return $this->housingAssistance;
    }

    public function setHousingAssistance(?float $housingAssistance): static
    {
        $this->housingAssistance = $housingAssistance;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPurposeUse(): ?string
    {
        return $this->purposeUse;
    }

    public function setPurposeUse(?string $purposeUse): static
    {
        $this->purposeUse = $purposeUse;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPaymentPeriod(): ?string
    {
        return $this->paymentPeriod;
    }

    public function setPaymentPeriod(?string $paymentPeriod): static
    {
        $this->paymentPeriod = $paymentPeriod;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getPaymentDate(): ?int
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?int $paymentDate): static
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function getPrivateComment(): ?string
    {
        return $this->privateComment;
    }

    public function setPrivateComment(?string $privateComment): static
    {
        $this->privateComment = $privateComment;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): static
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return Collection<int, rentalDocument>
     */
    public function getRentalDocuments(): Collection
    {
        return $this->rentalDocuments;
    }

    public function addRentalDocument(RentalDocument $rentalDocument): static
    {
        if (!$this->rentalDocuments->contains($rentalDocument)) {
            $this->rentalDocuments->add($rentalDocument);
            $rentalDocument->setRental($this);
        }

        return $this;
    }

    public function removeRentalDocument(rentalDocument $rentalDocument): static
    {
        if ($this->rentalDocuments->removeElement($rentalDocument)) {
            // set the owning side to null (unless already changed)
            if ($rentalDocument->getRental() === $this) {
                $rentalDocument->setRental(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tenant>
     */
    public function getTenants(): Collection
    {
        return $this->tenants;
    }

    public function addTenant(Tenant $tenant): static
    {
        if (!$this->tenants->contains($tenant)) {
            $this->tenants->add($tenant);
            $tenant->setRental($this);
        }

        return $this;
    }

    public function removeTenant(Tenant $tenant): static
    {
        if ($this->tenants->removeElement($tenant)) {
            // set the owning side to null (unless already changed)
            if ($tenant->getRental() === $this) {
                $tenant->setRental(null);
            }
        }

        return $this;
    }

    public function getGarageParkingBoxRent(): ?float
    {
        return $this->garageParkingBoxRent;
    }

    public function setGarageParkingBoxRent(?float $garageParkingBoxRent): static
    {
        $this->garageParkingBoxRent = $garageParkingBoxRent;

        return $this;
    }

}
