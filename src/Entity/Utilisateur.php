<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

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

    #[ORM\Column(nullable: true)]
    private ?bool $civilite = null;

    #[ORM\Column(length: 50)]
    private ?string $nomUsuel = null;

    #[ORM\Column(length: 50)]
    private ?string $nomNaissance = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 15)]
    private ?string $numtel = null;

    #[ORM\OneToMany(targetEntity: Inscrire::class, mappedBy: 'utilisateur')]
    private Collection $inscrires;

    #[ORM\ManyToMany(targetEntity: Suivre::class, mappedBy: 'utilisateur')]
    private Collection $suivres;

    #[ORM\OneToMany(targetEntity: Emarger::class, mappedBy: 'utilisateur')]
    private Collection $emargers;

    public function __construct()
    {
        $this->inscrires = new ArrayCollection();
        $this->suivres = new ArrayCollection();
        $this->emargers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isCivilite(): ?bool
    {
        return $this->civilite;
    }

    public function setCivilite(?bool $civilite): static
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getNomUsuel(): ?string
    {
        return $this->nomUsuel;
    }

    public function setNomUsuel(string $nomUsuel): static
    {
        $this->nomUsuel = $nomUsuel;

        return $this;
    }

    public function getNomNaissance(): ?string
    {
        return $this->nomNaissance;
    }

    public function setNomNaissance(string $nomNaissance): static
    {
        $this->nomNaissance = $nomNaissance;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(string $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    /**
     * @return Collection<int, Inscrire>
     */
    public function getInscrires(): Collection
    {
        return $this->inscrires;
    }

    public function addInscrire(Inscrire $inscrire): static
    {
        if (!$this->inscrires->contains($inscrire)) {
            $this->inscrires->add($inscrire);
            $inscrire->setUtilisateur($this);
        }

        return $this;
    }

    public function removeInscrire(Inscrire $inscrire): static
    {
        if ($this->inscrires->removeElement($inscrire)) {
            // set the owning side to null (unless already changed)
            if ($inscrire->getUtilisateur() === $this) {
                $inscrire->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Suivre>
     */
    public function getSuivres(): Collection
    {
        return $this->suivres;
    }

    public function addSuivre(Suivre $suivre): static
    {
        if (!$this->suivres->contains($suivre)) {
            $this->suivres->add($suivre);
            $suivre->addUtilisateur($this);
        }

        return $this;
    }

    public function removeSuivre(Suivre $suivre): static
    {
        if ($this->suivres->removeElement($suivre)) {
            $suivre->removeUtilisateur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Emarger>
     */
    public function getEmargers(): Collection
    {
        return $this->emargers;
    }

    public function addEmarger(Emarger $emarger): static
    {
        if (!$this->emargers->contains($emarger)) {
            $this->emargers->add($emarger);
            $emarger->setUtilisateur($this);
        }

        return $this;
    }

    public function removeEmarger(Emarger $emarger): static
    {
        if ($this->emargers->removeElement($emarger)) {
            // set the owning side to null (unless already changed)
            if ($emarger->getUtilisateur() === $this) {
                $emarger->setUtilisateur(null);
            }
        }

        return $this;
    }
}
