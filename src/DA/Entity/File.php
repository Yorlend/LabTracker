<?php

namespace App\DA\Entity;

use App\DA\Repository\MSFileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MSFileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(length: 255)]
    public ?string $path = null;

    #[ORM\ManyToOne(targetEntity: Lab::class, inversedBy: 'files')]
    #[ORM\JoinColumn(name: 'lab_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    public ?Lab $lab = null;

    #[ORM\ManyToOne(targetEntity: Solution::class, inversedBy: 'files')]
    #[ORM\JoinColumn(name: 'solution_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    public ?Solution $solution = null;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getName(): ?string
//    {
//        return $this->name;
//    }
//
//    public function setName(string $name): static
//    {
//        $this->name = $name;
//
//        return $this;
//    }
//
//    public function getLabId(): ?Lab
//    {
//        return $this->lab_id;
//    }
//
//    public function setLabId(?Lab $lab_id): static
//    {
//        $this->lab_id = $lab_id;
//
//        return $this;
//    }
//
//    public function getSolutionId(): ?Solution
//    {
//        return $this->solution_id;
//    }
//
//    public function setSolutionId(?Solution $solution_id): static
//    {
//        $this->solution_id = $solution_id;
//
//        return $this;
//    }
}
