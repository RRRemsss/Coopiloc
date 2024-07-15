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

    #[ORM\Column(length: 150)]
    private ?string $mail = null;

    #[ORM\OneToOne(mappedBy: 'personDetail', cascade: ['persist', 'remove'])]
    private ?LeaseParty $leaseParty = null;

    #[ORM\OneToOne(mappedBy: 'personDetail', cascade: ['persist', 'remove'])]
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getLeaseParty(): ?LeaseParty
    {
        return $this->leaseParty;
    }

    public function setLeaseParty(?LeaseParty $leaseParty): static
    {
        // unset the owning side of the relation if necessary
        if ($leaseParty === null && $this->leaseParty !== null) {
            $this->leaseParty->setPersonDetail(null);
        }

        // set the owning side of the relation if necessary
        if ($leaseParty !== null && $leaseParty->getPersonDetail() !== $this) {
            $leaseParty->setPersonDetail($this);
        }

        $this->leaseParty = $leaseParty;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        // set the owning side of the relation if necessary
        if ($user->getPersonDetail() !== $this) {
            $user->setPersonDetail($this);
        }

        $this->user = $user;

        return $this;
    }
}
