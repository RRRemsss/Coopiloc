<?php

namespace App\Entity;

use App\Repository\RentalDocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentalDocumentRepository::class)]
class RentalDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $documentType = null;

    #[ORM\Column(nullable: true)]
    private ?int $issueDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $dueDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePathRentalDocument = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $otherAddress = null;

    #[ORM\ManyToOne(inversedBy: 'rentalDocuments')]
    private ?Rental $rental = null;
  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentType(): ?string
    {
        return $this->documentType;
    }

    public function setDocumentType(?string $documentType): static
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getIssueDate(): ?int
    {
        return $this->issueDate;
    }

    public function setiIsueDate(?int $issueDate): static
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    public function getDueDate(): ?int
    {
        return $this->dueDate;
    }

    public function setDueDate(?int $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getFilePathRentalDocument (): ?string
    {
        return $this->filePathRentalDocument ;
    }

    public function setFilePathRentalDocument (?string $filePathRentalDocument ): static
    {
        $this->filePathRentalDocument  = $filePathRentalDocument ;

        return $this;
    }

    public function getOtherAddress(): ?string
    {
        return $this->otherAddress;
    }

    public function setOtherAddress(?string $otherAddress): static
    {
        $this->otherAddress = $otherAddress;

        return $this;
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
}
