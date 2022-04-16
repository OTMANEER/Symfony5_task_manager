<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;



/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;


    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=true)
     */
    private $username;

/**
     * @ORM\Column(type="string", length=180, unique=true, nullable=true)
     */
    private $password2;
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $encpassword;


    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="users", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true , onDelete="SET NULL")
     */
    private $groupId;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="userId")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="managerId")
     */
    private $projects;
    
    public function __toString()
    {
        return $this->name;
    }
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        $this->username = $name.$this->prenom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        $this->username = $this->name.$prenom;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getEncpassword(): ?string
    {
        return $this->encpassword;
    }
    public function setEncpassword(string $encpassword): self
    {
        $this->encpassword = $encpassword;

        return $this;
    }
    public function getpassword2(): ?string
    {
        return $this->password2;
    }
    public function setpassword2(?string $password2): ?string
    {
        $this->password2 = $password2;

        return $this;
    }
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->encpassword;
    }

    public function getSalt(): ?string
    {
        return NULL;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // $roles[] = json_encode($this->roles);
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */

    public function getUsername(): ?string
    {
        return $this->username;
    }


    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

   

   

    public function getGroupId(): ?Group
    {
        return $this->groupId;
    }

    public function setGroupId(?Group $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setUserId($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getUserId() === $this) {
                $task->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setManagerId($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getManagerId() === $this) {
                $project->setManagerId(null);
            }
        }

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
}
