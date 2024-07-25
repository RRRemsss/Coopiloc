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

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\OneToOne(inversedBy: 'tenantPersonDetail', cascade: ['persist', 'remove'])]
    private ?LeaseParty $leasePartyTenant = null;

    #[ORM\OneToOne(inversedBy: 'guarantorPersonDetail', cascade: ['persist', 'remove'])]
    private ?LeaseParty $leasePartyGuarantor = null;

    #[ORM\OneToOne(inversedBy: 'personDetail', cascade: ['persist', 'remove'])]
    private ?User $user = null;

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

    public function getLeasePartyTenant(): ?leaseParty
    {
        return $this->leasePartyTenant;
    }

    public function setLeasePartyTenant(?leaseParty $leasePartyTenant): static
    {
        $this->leasePartyTenant = $leasePartyTenant;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLeasePartyGuarantor(): ?LeaseParty
    {
        return $this->leasePartyGuarantor;
    }

    public function setLeasePartyGuarantor(?LeaseParty $leasePartyGuarantor): static
    {
        $this->leasePartyGuarantor = $leasePartyGuarantor;

        return $this;
    }


}
