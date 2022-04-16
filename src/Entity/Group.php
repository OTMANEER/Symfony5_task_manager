<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
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
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="groupId", orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $leaderId;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="groupId")
     */
    private $tasks;

    public function __toString()
    {
        return $this->description;
    }

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setGroupId($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getGroupId() === $this) {
                $user->setGroupId(null);
            }
        }

        return $this;
    }

    public function getLeaderId(): ?User
    {
        return $this->leaderId;
    }

    public function setLeaderId(User $leaderId): self
    {
        $this->leaderId = $leaderId;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTasks(Task $tasks): self
    {
        if (!$this->tasks->contains($tasks)) {
            $this->tasks[] = $tasks;
            $tasks->setGroupId($this);
        }

        return $this;
    }

    public function removeTasks(Task $tasks): self
    {
        if ($this->tasks->removeElement($tasks)) {
            // set the owning side to null (unless already changed)
            if ($tasks->getGroupId() === $this) {
                $tasks->setGroupId(null);
            }
        }

        return $this;
    }
}
