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

    #[ORM\Column(nullable: true)]
    private ?int $receiptDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $noticeRentDueDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $uploadRentalDocumentPath = null;

    #[ORM\ManyToOne(inversedBy: 'rentalDocuments')]
    private ?Rental $rental = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceiptDate(): ?int
    {
        return $this->receiptDate;
    }

    public function setReceiptDate(?int $receiptDate): static
    {
        $this->receiptDate = $receiptDate;

        return $this;
    }

    public function getNoticeRentDueDate(): ?int
    {
        return $this->noticeRentDueDate;
    }

    public function setNoticeRentDueDate(?int $noticeRentDueDate): static
    {
        $this->noticeRentDueDate = $noticeRentDueDate;

        return $this;
    }

    public function getuploadRentalDocumentPath (): ?string
    {
        return $this->uploadRentalDocumentPath ;
    }

    public function setuploadRentalDocumentPath (?string $uploadRentalDocumentPath ): static
    {
        $this->uploadRentalDocumentPath  = $uploadRentalDocumentPath ;

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
