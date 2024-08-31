<?php

namespace App\Entity;

use App\Repository\TenantDocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TenantDocumentRepository::class)]
class TenantDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $tenantDocumentType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePathTenantDocument = null;

    #[ORM\Column(nullable: true)]
    private ?int $documentSize = null;

    #[ORM\ManyToOne(inversedBy: 'tenantDocuments')]
    private ?Tenant $tenant = null;

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

    public function getTenantDocumentType(): ?string
    {
        return $this->tenantDocumentType;
    }

    public function setTenantDocumentType(?string $tenantDocumentType): static
    {
        $this->tenantDocumentType = $tenantDocumentType;

        return $this;
    }

    public function getFilePathTenantDocument(): ?string
    {
        return $this->filePathTenantDocument;
    }

    public function setFilePathTenantDocument(?string $filePathTenantDocument): static
    {
        $this->filePathTenantDocument = $filePathTenantDocument;

        return $this;
    }

    public function getDocumentSize(): ?int
    {
        return $this->documentSize;
    }

    public function setDocumentSize(?int $documentSize): static
    {
        $this->documentSize = $documentSize;

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
}
