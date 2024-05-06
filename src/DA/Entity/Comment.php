<?php

namespace App\DA\Entity;

use App\DA\Repository\MSCommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MSCommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTimeInterface $data = null;

    #[ORM\ManyToOne(targetEntity: Solution::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(name: 'solution_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    public ?Solution $solution = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    public ?User $user = null;



//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getText(): ?string
//    {
//        return $this->text;
//    }
//
//    public function setText(string $text): static
//    {
//        $this->text = $text;
//
//        return $this;
//    }
//
//    public function getData(): ?\DateTimeInterface
//    {
//        return $this->data;
//    }
//
//    public function setData(\DateTimeInterface $data): static
//    {
//        $this->data = $data;
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
//
//    public function getUserId(): ?User
//    {
//        return $this->user_id;
//    }
//
//    public function setUserId(?User $user_id): static
//    {
//        $this->user_id = $user_id;
//
//        return $this;
//    }
}
