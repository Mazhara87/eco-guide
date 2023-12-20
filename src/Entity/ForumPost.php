<?php

namespace App\Entity;

use App\Repository\ForumPostRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForumPostRepository::class)]
class ForumPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $summary = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    // DEFAULT VALUES
    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    #[ORM\ManyToOne(inversedBy: 'forumPosts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSummary(): ?string
    {
        // $this->summary;
        return $this->summary;
    }

    public function setSummary(?string $summary): static
    {
       
        $this->summary = $summary;
        return $this;
    }
  

}
