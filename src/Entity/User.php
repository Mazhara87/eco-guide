<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Utilisateur avec ce mail existe deja ')]
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
    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ForumPost::class)]
    private Collection $forumPosts;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Project::class)]
    private Collection $projects;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ProjectSupporter::class)]
    private Collection $projectSupporters;

   /**
 * @ORM\OneToMany(targetEntity=ForumComment::class, mappedBy="user")
 */
private $comments;


    // DEFAULT VALUES
    public function __construct()
    {
        $this->forumPosts = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->projectSupporters = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    // WHEN YOU WANT TO DISPLAY AN OBJECT
    public function __toString()
    {
        return $this->name.' - '. $this->email;
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
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

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


    // public function setPassword(string $password): static
    // {
    //     // Переместите логику шифрования пароля в сервисный слой, но для простоты добавлено сюда
    //     $this->password = $password;

    //     return $this;
    // }

      /**
     * @see PasswordAuthenticatedUserInterface
     */
//    public function setPassword(string $password): static
//     {
//         // Убедимся, что пароль не пустой
//         if (!empty($password)) {
//             // Хешируем пароль с использованием Bcrypt
//             $options = ['cost' => 10];
//             $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

//             // Устанавливаем хешированный пароль
//             $this->password = $hashedPassword;
//         }

//         return $this;
//     }
public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
    public function validatePassword(UserPasswordHasherInterface $passwordHasher): void
    {
        if ($this->password !== null) {
            $this->password = $passwordHasher->hashPassword($this, $this->password);
        }
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    /**
     * @return Collection<int, ForumPost>
     */
    public function getForumPosts(): Collection
    {
        return $this->forumPosts;
    }

    public function addForumPost(ForumPost $forumPost): static
    {
        if (!$this->forumPosts->contains($forumPost)) {
            $this->forumPosts->add($forumPost);
            $forumPost->setUser($this);
        }

        return $this;
    }

    public function removeForumPost(ForumPost $forumPost): static
    {
        if ($this->forumPosts->removeElement($forumPost)) {
            // set the owning side to null (unless already changed)
            if ($forumPost->getUser() === $this) {
                $forumPost->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setUser($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getUser() === $this) {
                $project->setUser(null);
            }
        }

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
            $projectSupporter->setUser($this);
        }

        return $this;
    }

    public function removeProjectSupporter(ProjectSupporter $projectSupporter): static
    {
        if ($this->projectSupporters->removeElement($projectSupporter)) {
            // set the owning side to null (unless already changed)
            if ($projectSupporter->getUser() === $this) {
                $projectSupporter->setUser(null);
            }
        }

        return $this;
    }
}