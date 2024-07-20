<?php

namespace App\Entity;

use App\Repository\DescriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DescriptionRepository::class)]
class Description
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le nombre ne peut pas être inférieur à {{ limit }}')]
    private ?float $area = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le nombre ne peut pas être inférieur à {{ limit }}')]
    private ?int $numberOfRooms = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le nombre ne peut pas être inférieur à {{ limit }}')]
    private ?int $numberOfBedrooms = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le nombre ne peut pas être inférieur à {{ limit }}')]
    private ?\DateTimeInterface $constructionDate = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le nombre ne peut pas être inférieur à {{ limit }}')]
    private ?int $numberOfBathrooms = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le nombre ne peut pas être inférieur à {{ limit }}')]
    private ?int $numberOfShower = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $propertyType = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $legalRegime = null;

    #[ORM\Column(nullable: true)]
    private ?bool $furnished = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $parking = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $dependency = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $cellarType = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $buildingLot = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $thousandths = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $equipment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $privateComment = null;

    #[ORM\ManyToOne(inversedBy: 'descriptions')]
    private ?Property $property = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArea(): ?float
    {
        return $this->area;
    }

    public function setArea(?float $area): static
    {
        $this->area = $area;

        return $this;
    }

    public function getNumberOfRooms(): ?int
    {
        return $this->numberOfRooms;
    }

    public function setNumberOfRooms(?int $numberOfRooms): static
    {
        $this->numberOfRooms = $numberOfRooms;

        return $this;
    }

    public function getNumberOfBedrooms(): ?int
    {
        return $this->numberOfBedrooms;
    }

    public function setNumberOfBedrooms(?int $numberOfBedrooms): static
    {
        $this->numberOfBedrooms = $numberOfBedrooms;

        return $this;
    }

    public function getConstructionDate(): ?\DateTimeInterface
    {
        return $this->constructionDate;
    }

    public function setConstructionDate(?\DateTimeInterface $constructionDate): static
    {
        $this->constructionDate = $constructionDate;

        return $this;
    }

    public function getNumberOfBathrooms(): ?int
    {
        return $this->numberOfBathrooms;
    }

    public function setNumberOfBathrooms(?int $numberOfBathrooms): static
    {
        $this->numberOfBathrooms = $numberOfBathrooms;

        return $this;
    }

    public function getNumberOfShower(): ?int
    {
        return $this->numberOfShower;
    }

    public function setNumberOfShower(?int $numberOfShower): static
    {
        $this->numberOfShower = $numberOfShower;

        return $this;
    }

    public function getPropertyType(): ?string
    {
        return $this->propertyType;
    }

    public function setPropertyType(?string $propertyType): static
    {
        $this->propertyType = $propertyType;

        return $this;
    }

    public function getLegalRegime(): ?string
    {
        return $this->legalRegime;
    }

    public function setLegalRegime(?string $legalRegime): static
    {
        $this->legalRegime = $legalRegime;

        return $this;
    }

    public function isFurnished(): ?bool
    {
        return $this->furnished;
    }

    public function setFurnished(?bool $furnished): static
    {
        $this->furnished = $furnished;

        return $this;
    }

    public function getParking(): ?string
    {
        return $this->parking;
    }

    public function setParking(?string $parking): static
    {
        $this->parking = $parking;

        return $this;
    }

    public function getDependency(): ?string
    {
        return $this->dependency;
    }

    public function setDependency(?string $dependency): static
    {
        $this->dependency = $dependency;

        return $this;
    }

    public function getCellarType(): ?string
    {
        return $this->cellarType;
    }

    public function setCellarType(?string $cellarType): static
    {
        $this->cellarType = $cellarType;

        return $this;
    }

    public function getBuildingLot(): ?string
    {
        return $this->buildingLot;
    }

    public function setBuildingLot(?string $buildingLot): static
    {
        $this->buildingLot = $buildingLot;

        return $this;
    }

    public function getThousandths(): ?string
    {
        return $this->thousandths;
    }

    public function setThousandths(?string $thousandths): static
    {
        $this->thousandths = $thousandths;

        return $this;
    }

    public function getEquipment(): ?array
    {
        return $this->equipment;
    }

    public function setEquipment(?array $equipment): static
    {
        $this->equipment = $equipment;

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

    public function getPrivateComment(): ?string
    {
        return $this->privateComment;
    }

    public function setPrivateComment(?string $privateComment): static
    {
        $this->privateComment = $privateComment;

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
