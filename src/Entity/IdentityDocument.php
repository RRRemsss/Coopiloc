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

    #[ORM\Column(length: 50)]
    private ?string $identityDocumentType = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $identityNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $expirationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $uploadIdentityPath = null;

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

    public function getuploadIdentityPath(): ?string
    {
        return $this->uploadIdentityPath;
    }

    public function setuploadIdentityPath(?string $uploadIdentityPath): static
    {
        $this->uploadIdentityPath = $uploadIdentityPath;

        return $this;
    }
}
