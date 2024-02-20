<?php

namespace App\Entity;

use App\Repository\ForumCommentRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\DBAL\Types\Types; // Эту строку добавьте
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;
use App\Entity\ForumPost;

#[ORM\Entity(repositoryClass: ForumCommentRepository::class)]

/**
 * @ORM\Table(name="forum_comments")
 */
class ForumComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'forumPosts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ForumPost $post = null;


    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;


    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    // ...

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }


     /**
     * @ORM\Column(type="integer")
     */
    private ?int $userId;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $postId;

    // ...

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPostId(): ?int
    {
        return $this->postId;
    }

    public function setPostId(?int $postId): self
    {
        $this->postId = $postId;

        return $this;
    }

  /**
 * @ORM\Column(type="text")
 * @Assert\NotBlank
 */
private $title;

public function getTitle(): ?string
{
    return $this->title;
}

public function setTitle(string $title): self
{
    $this->title = $title;

    return $this;
}

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    
    public function getPost(): ?ForumPost
    {
        return $this->post;
    }

    public function setPost(?ForumPost $post): self
    {
        $this->post = $post;

        return $this;
    }
    
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
