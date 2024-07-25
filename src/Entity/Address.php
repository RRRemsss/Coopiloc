<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $streetName = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $building = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $floor = null;

    #[ORM\Column(length: 80)]
    private ?string $city = null;

    #[ORM\Column(length: 10)]
    private ?string $postCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $country = null;

    /**
     * @var Collection<int, Property>
     */
    #[ORM\OneToMany(targetEntity: Property::class, mappedBy: 'address')]
    private Collection $properties;

    /**
     * @var Collection<int, LeaseParty>
     */
    #[ORM\OneToMany(targetEntity: LeaseParty::class, mappedBy: 'guarantorAddress')]
    private Collection $leaseParties;

    /**
     * @var Collection<int, LeaseParty>
     */
    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->leaseParties = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): static
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getBuilding(): ?string
    {
        return $this->building;
    }

    public function setBuilding(?string $building): static
    {
        $this->building = $building;

        return $this;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function setFloor(?string $floor): static
    {
        $this->floor = $floor;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): static
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): static
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->setAddress($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): static
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getAddress() === $this) {
                $property->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LeaseParty>
     */
    public function getLeaseParties(): Collection
    {
        return $this->leaseParties;
    }

    public function addLeaseParty(LeaseParty $leaseParty): static
    {
        if (!$this->leaseParties->contains($leaseParty)) {
            $this->leaseParties->add($leaseParty);
            $leaseParty->setGuarantorAddress($this);
        }

        return $this;
    }

    public function removeLeaseParty(LeaseParty $leaseParty): static
    {
        if ($this->leaseParties->removeElement($leaseParty)) {
            // set the owning side to null (unless already changed)
            if ($leaseParty->getGuarantorAddress() === $this) {
                $leaseParty->setGuarantorAddress(null);
            }
        }

        return $this;
    }

}
