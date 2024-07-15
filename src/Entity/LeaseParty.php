<?php

namespace App\Entity;

use App\Repository\LeasePartyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeasePartyRepository::class)]
class LeaseParty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $leasePartyType = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $civility = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $placeOfBirth = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(nullable: true)]
    private ?float $monthlyIncome = null;

    /**
     * @var Collection<int, Rental>
     */
    #[ORM\ManyToMany(targetEntity: Rental::class, mappedBy: 'leaseParties')]
    private Collection $rentals;

    #[ORM\OneToOne(inversedBy: 'leaseParty', cascade: ['persist', 'remove'])]
    private ?identityDocument $identityDocuments = null;

    #[ORM\ManyToOne(inversedBy: 'leaseParties')]
    private ?Address $address = null;

    #[ORM\OneToOne(inversedBy: 'leaseParty', cascade: ['persist', 'remove'])]
    private ?personDetail $personDetail = null;

    public function __construct()
    {
        $this->rentals = new ArrayCollection();
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

    public function getLeasePartyType(): ?string
    {
        return $this->leasePartyType;
    }

    public function setLeasePartyType(?string $leasePartyType): static
    {
        $this->leasePartyType = $leasePartyType;

        return $this;
    }

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(?string $civility): static
    {
        $this->civility = $civility;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(?string $placeOfBirth): static
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getMonthlyIncome(): ?float
    {
        return $this->monthlyIncome;
    }

    public function setMonthlyIncome(float $monthlyIncome): static
    {
        $this->monthlyIncome = $monthlyIncome;

        return $this;
    }

    /**
     * @return Collection<int, Rental>
     */
    public function getRentals(): Collection
    {
        return $this->rentals;
    }

    public function addRental(Rental $rental): static
    {
        if (!$this->rentals->contains($rental)) {
            $this->rentals->add($rental);
            $rental->addLeaseParty($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): static
    {
        if ($this->rentals->removeElement($rental)) {
            $rental->removeLeaseParty($this);
        }

        return $this;
    }

    public function getIdentityDocuments(): ?identityDocument
    {
        return $this->identityDocuments;
    }

    public function setIdentityDocuments(?identityDocument $identityDocuments): static
    {
        $this->identityDocuments = $identityDocuments;

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

    public function getPersonDetail(): ?personDetail
    {
        return $this->personDetail;
    }

    public function setPersonDetail(?personDetail $personDetail): static
    {
        $this->personDetail = $personDetail;

        return $this;
    }
}
