<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'text')] // Изменено на 'text'
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: ProjectSupporter::class)]
    private Collection $projectSupporter;

    //DEFAULT VALUES
    public function __construct()
    {
        $this->projectSupporter = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, ProjectSupporter>
     */
    public function getProjectSupporter(): Collection
    {
        return $this->projectSupporter;
    }

    public function addProjectSupporter(ProjectSupporter $projectSupporter): static
    {
        if (!$this->projectSupporter->contains($projectSupporter)) {
            $this->projectSupporter->add($projectSupporter);
            $projectSupporter->setProject($this);
        }

        return $this;
    }

    public function removeProjectSupporter(ProjectSupporter $projectSupporter): static
    {
        if ($this->projectSupporter->removeElement($projectSupporter)) {
            // set the owning side to null (unless already changed)
            if ($projectSupporter->getProject() === $this) {
                $projectSupporter->setProject(null);
            }
        }

        return $this;
    }
}
