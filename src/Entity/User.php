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
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $cpf = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Project::class)]
    private Collection $myProjects;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'users')]
    private Collection $proposals;

    #[ORM\OneToMany(mappedBy: 'freelancer', targetEntity: JobTitle::class, orphanRemoval: true)]
    private Collection $jobTitles;

    #[ORM\ManyToMany(targetEntity: Expertise::class, inversedBy: 'users')]
    private Collection $expertises;   

    public function __construct()
    {
        $this->myProjects = new ArrayCollection();
        $this->proposals = new ArrayCollection();
        $this->jobTitles = new ArrayCollection();
        $this->expertises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(?string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getMyProjects(): Collection
    {
        return $this->myProjects;
    }

    public function addMyProject(Project $myProject): self
    {
        if (!$this->myProjects->contains($myProject)) {
            $this->myProjects->add($myProject);
            $myProject->setOwner($this);
        }

        return $this;
    }

    public function removeMyProject(Project $myProject): self
    {
        if ($this->myProjects->removeElement($myProject)) {
            // set the owning side to null (unless already changed)
            if ($myProject->getOwner() === $this) {
                $myProject->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProposals(): Collection
    {
        return $this->proposals;
    }

    public function addProposal(Project $proposal): self
    {
        if (!$this->proposals->contains($proposal)) {
            $this->proposals->add($proposal);
        }

        return $this;
    }

    public function removeProposal(Project $proposal): self
    {
        $this->proposals->removeElement($proposal);

        return $this;
    }

    /**
     * @return Collection<int, JobTitle>
     */
    public function getJobTitles(): Collection
    {
        return $this->jobTitles;
    }

    public function addJobTitle(JobTitle $jobTitle): self
    {
        if (!$this->jobTitles->contains($jobTitle)) {
            $this->jobTitles->add($jobTitle);
            $jobTitle->setFreelancer($this);
        }

        return $this;
    }

    public function removeJobTitle(JobTitle $jobTitle): self
    {
        if ($this->jobTitles->removeElement($jobTitle)) {
            // set the owning side to null (unless already changed)
            if ($jobTitle->getFreelancer() === $this) {
                $jobTitle->setFreelancer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expertise>
     */
    public function getExpertises(): Collection
    {
        return $this->expertises;
    }

    public function addExpertise(Expertise $expertise): self
    {
        if (!$this->expertises->contains($expertise)) {
            $this->expertises->add($expertise);
        }

        return $this;
    }

    public function removeExpertise(Expertise $expertise): self
    {
        $this->expertises->removeElement($expertise);

        return $this;
    }

    

    

  
}
