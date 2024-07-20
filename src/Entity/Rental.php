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

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $purposeUse = null;

    #[ORM\Column]
    private ?int $duration = null;

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

    /**
     * @var Collection<int, LeaseParty>
     */
    #[ORM\ManyToMany(targetEntity: LeaseParty::class, inversedBy: 'rentals')]
    private Collection $leaseParties;

    public function __construct()
    {
        $this->rentalDocuments = new ArrayCollection();
        $this->leaseParties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRentalType(): ?string
    {
        return $this->leaseType;
    }

    public function setRentalType(string $leaseType): static
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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
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

    public function addRentalDocument(rentalDocument $rentalDocument): static
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
     * @return Collection<int, leaseParty>
     */
    public function getLeaseParties(): Collection
    {
        return $this->leaseParties;
    }

    public function addLeaseParty(leaseParty $leaseParty): static
    {
        if (!$this->leaseParties->contains($leaseParty)) {
            $this->leaseParties->add($leaseParty);
        }

        return $this;
    }

    public function removeLeaseParty(leaseParty $leaseParty): static
    {
        $this->leaseParties->removeElement($leaseParty);

        return $this;
    }
}
