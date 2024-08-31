<?php

namespace App\Entity;

use App\Repository\TenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TenantRepository::class)]
class Tenant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $civility = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $placeOfBirth = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $nationality = null;

    #[ORM\Column(length: 50)]
    private ?string $profession = null;

    #[ORM\Column]
    private ?float $monthlyIncome = null;

    #[ORM\Column]
    private ?bool $hasGuarantor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $privateComment = null;

       /**
     * @var Collection<int, guarantor>
     */
    #[ORM\OneToMany(targetEntity: Guarantor::class, mappedBy: 'tenant')]
    private Collection $guarantors;

    #[ORM\OneToOne(inversedBy: 'tenant', cascade: ['persist', 'remove'])]
    private ?IdentityLeaseParty $identityLeaseParty = null;

    #[ORM\OneToOne(inversedBy: 'tenant', cascade: ['persist', 'remove'])]
    private ?PersonDetail $personDetail = null;

    #[ORM\ManyToOne(inversedBy: 'tenants')]
    private ?Rental $rental = null;

    /**
     * @var Collection<int, tenantDocument>
     */
    #[ORM\OneToMany(targetEntity: TenantDocument::class, mappedBy: 'tenant', cascade: ['persist'])]
    private Collection $tenantDocuments;

    public function __construct()
    {
        $this->guarantors = new ArrayCollection();
        $this->tenantDocuments = new ArrayCollection();
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

    public function hasGuarantor(): ?bool
    {
        return $this->hasGuarantor;
    }

    public function setHasGuarantor(bool $hasGuarantor): static
    {
        $this->hasGuarantor = $hasGuarantor;

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
     * @return Collection<int, guarantor>
     */
    public function getGuarantors(): Collection
    {
        return $this->guarantors;
    }

    public function addGuarantor(Guarantor $guarantor): static
    {
        if (!$this->guarantors->contains($guarantor)) {
            $this->guarantors->add($guarantor);
            $guarantor->setTenant($this);
        }

        return $this;
    }

    public function removeGuarantor(Guarantor $guarantor): static
    {
        if ($this->guarantors->removeElement($guarantor)) {
            // set the owning side to null (unless already changed)
            if ($guarantor->getTenant() === $this) {
                $guarantor->setTenant(null);
            }
        }

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

    public function getPersonDetail(): ?PersonDetail
    {
        return $this->personDetail;
    }

    public function setPersonDetail(?PersonDetail $personDetail): static
    {
        $this->personDetail = $personDetail;

        return $this;
    }

    public function getFullName(): string
    {
        if ($this->personDetail) {
            return $this->personDetail->getFirstname() . ' ' . $this->personDetail->getLastname();
        }
        return 'Unknown'; // Valeur par défaut si les détails de la personne sont absents
    }

    public function getRental(): ?Rental
    {
        return $this->rental;
    }

    public function setRental(?Rental $rental): static
    {
        $this->rental = $rental;

        return $this;
    }

    /**
     * @return Collection<int, tenantDocument>
     */
    public function getTenantDocuments(): Collection
    {
        return $this->tenantDocuments;
    }

    public function addTenantDocument(TenantDocument $tenantDocument): static
    {
        if (!$this->tenantDocuments->contains($tenantDocument)) {
            $this->tenantDocuments->add($tenantDocument);
            $tenantDocument->setTenant($this);
        }

        return $this;
    }

    public function removeTenantDocument(TenantDocument $tenantDocument): static
    {
        if ($this->tenantDocuments->removeElement($tenantDocument)) {
            // set the owning side to null (unless already changed)
            if ($tenantDocument->getTenant() === $this) {
                $tenantDocument->setTenant(null);
            }
        }

        return $this;
    }
}
