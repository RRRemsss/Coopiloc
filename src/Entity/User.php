<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'Ce pseudo est déjà utilisé, veuillez en taper un autre')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 25)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $userStreetName = null;

    #[ORM\Column(length: 20)]
    private ?string $userPostCode = null;

    #[ORM\Column(length: 255)]
    private ?string $userCity = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $userCountryAddress = null;

    /**
     * @var Collection<int, Property>
     */
    #[ORM\OneToMany(targetEntity: Property::class, mappedBy: 'user')]
    private Collection $properties;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?PersonDetail $personDetail = null;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUserStreetName(): ?string
    {
        return $this->userStreetName;
    }

    public function setUserStreetName(string $userStreetName): static
    {
        $this->userStreetName = $userStreetName;

        return $this;
    }

    public function getUserPostCode(): ?string
    {
        return $this->userPostCode;
    }

    public function setUserPostCode(string $userPostCode): static
    {
        $this->userPostCode = $userPostCode;

        return $this;
    }

    public function getUserCity(): ?string
    {
        return $this->userCity;
    }

    public function setUserCity(string $userCity): static
    {
        $this->userCity = $userCity;

        return $this;
    }

    public function getUserCountryAddress(): ?string
    {
        return $this->userCountryAddress;
    }

    public function setUserCountryAddress(?string $userCountryAddress): static
    {
        $this->userCountryAddress = $userCountryAddress;

        return $this;
    }

    public function getFullName(): string
    {
        if ($this->personDetail) {
            return $this->personDetail->getFirstname() . ' ' . $this->personDetail->getLastname();
        }
        return 'Unknown'; // Default value
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $property->setUser($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): static
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getUser() === $this) {
                $property->setUser(null);
            }
        }

        return $this;
    }

    public function getPersonDetail(): ?PersonDetail
    {
        return $this->personDetail;
    }

    public function setPersonDetail(?PersonDetail $personDetail): static
    {
        // unset the owning side of the relation if necessary
        if ($personDetail === null && $this->personDetail !== null) {
            $this->personDetail->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($personDetail !== null && $personDetail->getUser() !== $this) {
            $personDetail->setUser($this);
        }

        $this->personDetail = $personDetail;

        return $this;
    }
}
