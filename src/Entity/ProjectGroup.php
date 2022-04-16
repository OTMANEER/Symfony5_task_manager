<?php

namespace App\Entity;

use App\Repository\ProjectGroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectGroupRepository::class)
 */
class ProjectGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="projectGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProject;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idGroup;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProject(): ?Project
    {
        return $this->idProject;
    }

    public function setIdProject(?Project $idProject): self
    {
        $this->idProject = $idProject;

        return $this;
    }

    public function getIdGroup(): ?Group
    {
        return $this->idGroup;
    }

    public function setIdGroup(?Group $idGroup): self
    {
        $this->idGroup = $idGroup;

        return $this;
    }

}
