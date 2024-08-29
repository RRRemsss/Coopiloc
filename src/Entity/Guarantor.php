<?php

namespace App\Entity;

use App\Repository\GuarantorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuarantorRepository::class)]
class Guarantor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $guarantorType = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $civility = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $placeOfBirth = null;

    #[ORM\Column(length: 125, nullable: true)]
    private ?string $nationality = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(nullable: true)]
    private ?float $monthlyIncome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $privateComment = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $guarantorCompanyName = null;

    #[ORM\ManyToOne(inversedBy: 'guarantors')]
    private ?Tenant $tenant = null;

    #[ORM\OneToOne(inversedBy: 'guarantor', cascade: ['persist', 'remove'])]
    private ?Address $address = null;

    #[ORM\OneToOne(inversedBy: 'guarantor', cascade: ['persist', 'remove'])]
    private ?PersonDetail $personDetail = null;

    #[ORM\OneToOne(inversedBy: 'guarantor', cascade: ['persist', 'remove'])]
    private ?IdentityLeaseParty $identityLeaseParty = null;

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

    public function getGuarantorType(): ?string
    {
        return $this->guarantorType;
    }

    public function setGuarantorType(string $guarantorType): static
    {
        $this->guarantorType = $guarantorType;

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

    public function setProfession(?string $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getMonthlyIncome(): ?float
    {
        return $this->monthlyIncome;
    }

    public function setMonthlyIncome(?float $monthlyIncome): static
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

    public function getGuarantorCompanyName(): ?string
    {
        return $this->guarantorCompanyName;
    }

    public function setGuarantorCompanyName(?string $guarantorCompanyName): static
    {
        $this->guarantorCompanyName = $guarantorCompanyName;

        return $this;
    }

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $tenant): static
    {
        $this->tenant = $tenant;

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

    public function getPersonDetail(): ?PersonDetail
    {
        return $this->personDetail;
    }

    public function setPersonDetail(?PersonDetail $personDetail): static
    {
        $this->personDetail = $personDetail;

        return $this;
    }

    public function getIdentityLeaseParty(): ?IdentityLeaseParty
    {
        return $this->identityLeaseParty;
    }

    public function setIdentityLeaseParty(?IdentityLeaseParty $identityLeaseParty): static
    {
        $this->identityLeaseParty = $identityLeaseParty;

        return $this;
    }
}
