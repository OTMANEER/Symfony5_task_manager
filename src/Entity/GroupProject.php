<?php

// ***********Inutile pour le moment*******************

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=GroupProjectRepository::class)
 */
class GroupProject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idGroup;

    /**
     * @ORM\Column(type="integer")
     */
    private $idProject;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdGroup(): ?int
    {
        return $this->idGroup;
    }

    public function setIdGroup(int $idGroup): self
    {
        $this->idGroup = $idGroup;

        return $this;
    }

    public function getIdProject(): ?int
    {
        return $this->idProject;
    }

    public function setIdProject(int $idProject): self
    {
        $this->idProject = $idProject;

        return $this;
    }
}
