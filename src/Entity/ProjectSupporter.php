<?php

namespace App\Entity;

use App\Repository\ProjectSupporterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectSupporterRepository::class)]
class ProjectSupporter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // #[ORM\ManyToOne(inversedBy: 'projectSupporters')]
    // #[ORM\JoinColumn(nullable: false)]
    // // private ?User $user = null;
    // private $user;

    // #[ORM\ManyToOne(inversedBy: 'projectSupporters', cascade: ['persist'])]
    // #[ORM\JoinColumn(nullable: false)]
    // // private ?Project $project = null;
    // private $project;

    #[ORM\ManyToOne(targetEntity: "App\Entity\User", cascade: ["persist"])] // Добавлен атрибут cascade
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Project", cascade: ["persist"])] // Добавлен атрибут cascade
    #[ORM\JoinColumn(nullable: false)]
    private $project;

   // Геттеры и сеттеры
    
    public function getId(): ?int
    {
        return $this->id;
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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }
}
