<?php

namespace App\Entity;

use App\Repository\JobTitleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobTitleRepository::class)]
class JobTitle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 10)]
    private ?string $experience_level = null;

    #[ORM\ManyToOne(inversedBy: 'jobTitles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $freelancer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getExperienceLevel(): ?string
    {
        return $this->experience_level;
    }

    public function setExperienceLevel(string $experience_level): self
    {
        $this->experience_level = $experience_level;

        return $this;
    }

    public function getFreelancer(): ?User
    {
        return $this->freelancer;
    }

    public function setFreelancer(?User $freelancer): self
    {
        $this->freelancer = $freelancer;

        return $this;
    }
}
