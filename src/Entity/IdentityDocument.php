<?php

namespace App\Entity;

use App\Repository\IdentityDocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IdentityDocumentRepository::class)]
class IdentityDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 50)]
    private ?string $identityDocumentType = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $identityNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $expirationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $uploadIdentityPath = null;

    #[ORM\OneToOne(mappedBy: 'identityDocuments', cascade: ['persist', 'remove'])]
    private ?LeaseParty $leaseParty = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    public function getuploadIdentityPath(): ?string
    {
        return $this->uploadIdentityPath;
    }

    public function setuploadIdentityPath(?string $uploadIdentityPath): static
    {
        $this->uploadIdentityPath = $uploadIdentityPath;

        return $this;
    }

    public function getLeaseParty(): ?LeaseParty
    {
        return $this->leaseParty;
    }

    public function setLeaseParty(?LeaseParty $leaseParty): static
    {
        // unset the owning side of the relation if necessary
        if ($leaseParty === null && $this->leaseParty !== null) {
            $this->leaseParty->setIdentityDocuments(null);
        }

        // set the owning side of the relation if necessary
        if ($leaseParty !== null && $leaseParty->getIdentityDocuments() !== $this) {
            $leaseParty->setIdentityDocuments($this);
        }

        $this->leaseParty = $leaseParty;

        return $this;
    }
}
