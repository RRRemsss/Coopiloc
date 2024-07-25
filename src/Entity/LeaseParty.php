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
    private ?string $nationality = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(nullable: true)]
    private ?float $monthlyIncome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $privateComment = null;

    #[ORM\Column]
    private ?bool $hasGuarantor = null;

    /**
     * @var Collection<int, Rental>
     */
    #[ORM\ManyToMany(targetEntity: Rental::class, mappedBy: 'leaseParties')]
    private Collection $rentals;

    #[ORM\OneToOne(inversedBy: 'leaseParty', cascade: ['persist', 'remove'])]
    private ?IdentityDocument $identityDocuments = null;

    /**Informations of Tenant**/
    #[ORM\OneToOne(mappedBy: 'leasePartyTenant', cascade: ['persist', 'remove'])]
    private ?PersonDetail $tenantPersonDetail = null;

    /**Informations of Guarantor**/
    #[ORM\OneToOne(mappedBy: 'leasePartyGuarantor', cascade: ['persist', 'remove'])]
    private ?PersonDetail $guarantorPersonDetail = null;

    #[ORM\ManyToOne(inversedBy: 'leaseParties')]
    private ?Address $guarantorAddress = null;

    #[ORM\OneToOne(targetEntity: LeaseParty::class, cascade: ['persist', 'remove'])]
    private ?LeaseParty $guarantor = null;

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
    
    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): static
    {
        $this->nationality = $nationality;

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

    public function getPrivateComment(): ?string
    {
        return $this->privateComment;
    }

    public function setPrivateComment(?string $privateComment): static
    {
        $this->privateComment = $privateComment;

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

    public function getTenantPersonDetail(): ?PersonDetail
    {
        return $this->tenantPersonDetail;
    }

    public function setTenantPersonDetail(?PersonDetail $tenantPersonDetail): static
    {
        // unset the owning side of the relation if necessary
        if ($tenantPersonDetail === null && $this->tenantPersonDetail !== null) {
            $this->tenantPersonDetail->setLeasePartyTenant(null);
        }

        // set the owning side of the relation if necessary
        if ($tenantPersonDetail !== null && $tenantPersonDetail->getLeasePartyTenant() !== $this) {
            $tenantPersonDetail->setLeasePartyTenant($this);
        }

        $this->tenantPersonDetail = $tenantPersonDetail;

        return $this;
    }

    public function getGuarantorPersonDetail(): ?PersonDetail
    {
        return $this->guarantorPersonDetail;
    }

    public function setGuarantorPersonDetail(?PersonDetail $guarantorPersonDetail): static
    {
        if ($guarantorPersonDetail === null && $this->guarantorPersonDetail !== null) {
            $this->guarantorPersonDetail->setLeasePartyGuarantor(null);
        }

        if ($guarantorPersonDetail !== null && $guarantorPersonDetail->getLeasePartyGuarantor() !== $this) {
            $guarantorPersonDetail->setLeasePartyGuarantor($this);
        }

        $this->guarantorPersonDetail = $guarantorPersonDetail;

        return $this;
    }

    public function hasGuarantor(): ?bool
    {
        return $this->hasGuarantor;
    }

    public function setHasGuarantor(bool $hasGuarantor): static
    {
        $this->hasGuarantor = $hasGuarantor;

        return $this;
    }

    public function getGuarantorAddress(): ?Address
    {
        return $this->guarantorAddress;
    }

    public function setGuarantorAddress(?Address $guarantorAddress): static
    {
        $this->guarantorAddress = $guarantorAddress;

        return $this;
    }

    public function getGuarantor(): ?LeaseParty
    {
        return $this->guarantor;
    }

    public function setGuarantor(?LeaseParty $guarantor): static
    {
        $this->guarantor = $guarantor;

        return $this;
    }
}
