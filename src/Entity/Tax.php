<?php

namespace App\Entity;

use App\Repository\TaxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaxRepository::class)]
class Tax
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $taxSystem = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $taxNumber = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $taxName = null;

    #[ORM\Column(nullable: true)]
    private ?float $taxAmount = null;

    #[ORM\Column(nullable: true)]
    private ?float $propertyTax = null;

    #[ORM\ManyToOne(inversedBy: 'taxes')]
    private ?Property $property = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaxSystem(): ?string
    {
        return $this->taxSystem;
    }

    public function setTaxSystem(?string $taxSystem): static
    {
        $this->taxSystem = $taxSystem;

        return $this;
    }

    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(?string $taxNumber): static
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function getTaxName(): ?string
    {
        return $this->taxName;
    }

    public function setTaxName(?string $taxName): static
    {
        $this->taxName = $taxName;

        return $this;
    }

    public function getTaxAmount(): ?float
    {
        return $this->taxAmount;
    }

    public function setTaxAmount(?float $taxAmount): static
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    public function getPropertyTax(): ?float
    {
        return $this->propertyTax;
    }

    public function setPropertyTax(?float $propertyTax): static
    {
        $this->propertyTax = $propertyTax;

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
