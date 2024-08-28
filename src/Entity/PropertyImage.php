<?php

namespace App\Entity;

use App\Repository\PropertyImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyImageRepository::class)]
class PropertyImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePathPropertyImage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isMain = null;

    #[ORM\ManyToOne(inversedBy: 'propertyImages')]
    private ?Property $property = null;

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

    public function getFilePathPropertyImage(): ?string
    {
        return $this->filePathPropertyImage;
    }

    public function setFilePathPropertyImage(?string $filePathPropertyImage): static
    {
        $this->filePathPropertyImage = $filePathPropertyImage;

        return $this;
    }

    public function isMain(): ?bool
    {
        return $this->isMain;
    }

    public function setMain(?bool $isMain): static
    {
        $this->isMain = $isMain;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): static
    {
        $this->property = $property;

        return $this;
    }
}
