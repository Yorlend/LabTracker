<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'FilesAdded')]
    private ?Lab $lab_id = null;

    #[ORM\ManyToOne(inversedBy: 'FilesAdded')]
    private ?Solution $solution_id = null;

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

    public function getLabId(): ?Lab
    {
        return $this->lab_id;
    }

    public function setLabId(?Lab $lab_id): static
    {
        $this->lab_id = $lab_id;

        return $this;
    }

    public function getSolutionId(): ?Solution
    {
        return $this->solution_id;
    }

    public function setSolutionId(?Solution $solution_id): static
    {
        $this->solution_id = $solution_id;

        return $this;
    }
}
