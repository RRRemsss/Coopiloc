<?php

namespace App\Entity;

use App\Repository\LandRegistryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LandRegistryRepository::class)]
class LandRegistry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $sheet = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $parcel = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(nullable: true)]
    private ?float $rentalValue = null;

    #[ORM\ManyToOne(inversedBy: 'landRegistries')]
    private ?Property $property = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSheet(): ?string
    {
        return $this->sheet;
    }

    public function setSheet(?string $sheet): static
    {
        $this->sheet = $sheet;

        return $this;
    }

    public function getParcel(): ?string
    {
        return $this->parcel;
    }

    public function setParcel(?string $parcel): static
    {
        $this->parcel = $parcel;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getRentalValue(): ?float
    {
        return $this->rentalValue;
    }

    public function setRentalValue(?float $rentalValue): static
    {
        $this->rentalValue = $rentalValue;

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
