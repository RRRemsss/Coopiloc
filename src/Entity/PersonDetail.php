<?php

namespace App\Entity;

use App\Repository\PersonDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonDetailRepository::class)]
class PersonDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\OneToOne(inversedBy: 'personDetail', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'personDetail', cascade: ['persist', 'remove'])]
    private ?Tenant $tenant = null;

    #[ORM\OneToOne(mappedBy: 'personDetail', cascade: ['persist', 'remove'])]
    private ?Guarantor $guarantor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $tenant): static
    {
        // unset the owning side of the relation if necessary
        if ($tenant === null && $this->tenant !== null) {
            $this->tenant->setPersonDetail(null);
        }

        // set the owning side of the relation if necessary
        if ($tenant !== null && $tenant->getPersonDetail() !== $this) {
            $tenant->setPersonDetail($this);
        }

        $this->tenant = $tenant;

        return $this;
    }

    public function getGuarantor(): ?Guarantor
    {
        return $this->guarantor;
    }

    public function setGuarantor(?Guarantor $guarantor): static
    {
        // unset the owning side of the relation if necessary
        if ($guarantor === null && $this->guarantor !== null) {
            $this->guarantor->setPersonDetail(null);
        }

        // set the owning side of the relation if necessary
        if ($guarantor !== null && $guarantor->getPersonDetail() !== $this) {
            $guarantor->setPersonDetail($this);
        }

        $this->guarantor = $guarantor;

        return $this;
    }
    
}
