<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
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
     * @ORM\Column(type="boolean")
     */
    private $done;

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
     * @ORM\ManyToOne(targetEntity=group::class, inversedBy="userId")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupId;

    /**
     * @ORM\ManyToOne(targetEntity=project::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projectId;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="tasks")
     */
    private $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function __toString()
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

    public function getDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): self
    {
        $this->done = $done;

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

    public function getGroupId(): ?group
    {
        return $this->groupId;
    }

    public function setGroupId(?group $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getProjectId(): ?project
    {
        return $this->projectId;
    }

    public function setProjectId(?project $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->userId;
    }

    public function setUserId(?user $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
