<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $dateInit;

    /**
     * @ORM\Column(type="date")
     */
    private $deadline;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="projectId", orphanRemoval=true)
     */
    private $tasks;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $managerId;

    /**
     * @ORM\OneToMany(targetEntity=ProjectGroup::class, mappedBy="idProject", orphanRemoval=true)
     */
    private $projectGroups;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->projectGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->title;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateInit(): ?\DateTimeInterface
    {
        return $this->dateInit;
    }

    public function setDateInit(\DateTimeInterface $dateInit): self
    {
        $this->dateInit = $dateInit;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

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
            $task->setProjectId($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProjectId() === $this) {
                $task->setProjectId(null);
            }
        }

        return $this;
    }

    public function getManagerId(): ?User
    {
        return $this->managerId;
    }

    public function setManagerId(?User $managerId): self
    {
        $this->managerId = $managerId;

        return $this;
    }

    /**
     * @return Collection|ProjectGroup[]
     */
    public function getProjectGroups(): Collection
    {
        return $this->projectGroups;
    }

    public function addProjectGroup(ProjectGroup $projectGroup): self
    {
        if (!$this->projectGroups->contains($projectGroup)) {
            $this->projectGroups[] = $projectGroup;
            $projectGroup->setIdProject($this);
        }

        return $this;
    }

    public function removeProjectGroup(ProjectGroup $projectGroup): self
    {
        if ($this->projectGroups->removeElement($projectGroup)) {
            // set the owning side to null (unless already changed)
            if ($projectGroup->getIdProject() === $this) {
                $projectGroup->setIdProject(null);
            }
        }

        return $this;
    }
}
