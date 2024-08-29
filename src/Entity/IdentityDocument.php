<?php

namespace App\Entity;

use App\Repository\IdentityDocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IdentityDocumentRepository::class)]
class IdentityDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePathIdentityDocument = null;

    #[ORM\ManyToOne(inversedBy: 'identityDocuments')]
    private ?IdentityLeaseParty $identityLeaseParty = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilePathIdentityDocument(): ?string
    {
        return $this->filePathIdentityDocument;
    }

    public function setFilePathIdentityDocument(?string $filePathIdentityDocument): static
    {
        $this->filePathIdentityDocument = $filePathIdentityDocument;

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
