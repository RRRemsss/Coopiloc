<?php

namespace App\Entity;

use App\Repository\TaxRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $siret = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateActivityStart = null;

    #[ORM\Column(nullable: true)]
    private ?float $housingTax = null;

    #[ORM\Column(nullable: true)]
    private ?float $propertyTax = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

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

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getdateActivityStart(): ?\DateTimeInterface
    {
        return $this->dateActivityStart;
    }

    public function setdateActivityStart(?\DateTimeInterface $dateActivityStart): static
    {
        $this->dateActivityStart = $dateActivityStart;

        return $this;
    }

    public function getHousingTax(): ?float
    {
        return $this->housingTax;
    }

    public function setHousingTax(?float $housingTax): static
    {
        $this->housingTax = $housingTax;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }
}
