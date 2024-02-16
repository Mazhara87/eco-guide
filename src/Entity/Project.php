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

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: ProjectSupporter::class)]
    private Collection $projectSupporters;
   
    #[ORM\Column(type:"string", length:255)]
    private $name;

    // Добавим свойство для описания проекта
    #[ORM\Column(type: 'text', nullable: false)]
    private ?string $description = null;
    
    // #[ORM\Column(type: 'integer', options: ['default' => 0])] 
     /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */   
    private $likeCount = 0; // Начальное значение счетчика лайков

       
    // DEFAULT VALUES
    public function __construct()
    {
        $this->projectSupporters = new ArrayCollection();
    }

    // Геттеры и сеттеры
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ProjectSupporter>
     */
    public function getProjectSupporters(): Collection
    {
        return $this->projectSupporters;
    }

    public function addProjectSupporter(ProjectSupporter $projectSupporter): static
    {
        if (!$this->projectSupporters->contains($projectSupporter)) {
            $this->projectSupporters->add($projectSupporter);
            $projectSupporter->setProject($this);
        }

        return $this;
    }

    public function removeProjectSupporter(ProjectSupporter $projectSupporter): static
    {
        if ($this->projectSupporters->removeElement($projectSupporter)) {
            // set the owning side to null (unless already changed)
            if ($projectSupporter->getProject() === $this) {
                $projectSupporter->setProject(null);
            }
        }

        return $this;
    }

    public function toArray(): array
{
    return [
        'id' => $this->getId(),
        'name' => $this->getName(),
        'description' => $this->getDescription(),
        // Добавьте другие свойства, если необходимо
    ];
}


    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    /**
     * Увеличивает счетчик лайков
     */
    public function incrementLikeCount(): void
    {
        $this->likeCount++;
    }

}