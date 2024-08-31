<?php

namespace App\Entity;

use App\Repository\GuarantorDocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuarantorDocumentRepository::class)]
class GuarantorDocument
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
    private ?string $guarantorDocumentType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePathGuarantorDocument = null;

    #[ORM\Column(nullable: true)]
    private ?int $documentSize = null;

    #[ORM\ManyToOne(inversedBy: 'guarantorDocuments')]
    private ?Guarantor $guarantor = null;

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

    public function getGuarantorDocumentType(): ?string
    {
        return $this->guarantorDocumentType;
    }

    public function setGuarantorDocumentType(?string $guarantorDocumentType): static
    {
        $this->guarantorDocumentType = $guarantorDocumentType;

        return $this;
    }

    public function getFilePathGuarantorDocument(): ?string
    {
        return $this->filePathGuarantorDocument;
    }

    public function setFilePathGuarantorDocument(?string $filePathGuarantorDocument): static
    {
        $this->filePathGuarantorDocument = $filePathGuarantorDocument;

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

    public function getGuarantor(): ?Guarantor
    {
        return $this->guarantor;
    }

    public function setGuarantor(?Guarantor $guarantor): static
    {
        $this->guarantor = $guarantor;

        return $this;
    }
}
