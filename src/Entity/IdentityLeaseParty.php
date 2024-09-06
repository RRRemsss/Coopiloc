<?php

namespace App\Entity;

use App\Repository\IdentityLeasePartyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IdentityLeasePartyRepository::class)]
class IdentityLeaseParty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $identityDocumentType = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $identityNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $expirationDate = null;

    #[ORM\OneToOne(mappedBy: 'identityLeaseParty', cascade: ['persist', 'remove'])]
    private ?Tenant $tenant = null;

    #[ORM\OneToOne(mappedBy: 'identityLeaseParty', cascade: ['persist', 'remove'])]
    private ?Guarantor $guarantor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentityDocumentType(): ?string
    {
        return $this->identityDocumentType;
    }

    public function setIdentityDocumentType(string $identityDocumentType): static
    {
        $this->identityDocumentType = $identityDocumentType;

        return $this;
    }

    public function getIdentityNumber(): ?string
    {
        return $this->identityNumber;
    }

    public function setIdentityNumber(?string $identityNumber): static
    {
        $this->identityNumber = $identityNumber;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(?\DateTimeInterface $expirationDate): static
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }


    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $tenant): static
    {
        // unset the owning side of the relation if necessary
        if ($tenant === null && $this->tenant !== null) {
            $this->tenant->setIdentityLeaseParty(null);
        }

        // set the owning side of the relation if necessary
        if ($tenant !== null && $tenant->getIdentityLeaseParty() !== $this) {
            $tenant->setIdentityLeaseParty($this);
        }

        $this->tenant = $tenant;

        return $this;
    }

    public function getGuarantor(): ?Guarantor
    {
        return $this->guarantor;
    }

    public function setGuarantor(?Guarantor $guarantor): static
    {
        // unset the owning side of the relation if necessary
        if ($guarantor === null && $this->guarantor !== null) {
            $this->guarantor->setIdentityLeaseParty(null);
        }

        // set the owning side of the relation if necessary
        if ($guarantor !== null && $guarantor->getIdentityLeaseParty() !== $this) {
            $guarantor->setIdentityLeaseParty($this);
        }

        $this->guarantor = $guarantor;

        return $this;
    }
}
