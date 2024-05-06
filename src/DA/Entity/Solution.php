<?php

namespace App\DA\Entity;

use App\DA\Repository\MSSolutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MSSolutionRepository::class)]
class Solution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    public ?int $state = null;

    #[ORM\ManyToOne(targetEntity: Lab::class, inversedBy: 'solutions')]
    #[ORM\JoinColumn(name: 'lab_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    public ?Lab $lab = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'solutions')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    public ?User $user = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'solution')]
    public Collection $comments;

    /**
     * @var Collection<int, File>
     */
    #[ORM\OneToMany(targetEntity: File::class, mappedBy: 'lab')]
    public Collection $files;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->files = new ArrayCollection();
    }
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getDescription(): ?string
//    {
//        return $this->description;
//    }
//
//    public function setDescription(?string $description): static
//    {
//        $this->description = $description;
//
//        return $this;
//    }
//
//    public function getState(): ?int
//    {
//        return $this->state;
//    }
//
//    public function setState(int $state): static
//    {
//        $this->state = $state;
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
//
//    /**
//     * @return Collection<int, Comment>
//     */
//    public function getCommentsAdded(): Collection
//    {
//        return $this->CommentsAdded;
//    }
//
//    public function addCommentsAdded(Comment $commentsAdded): static
//    {
//        if (!$this->CommentsAdded->contains($commentsAdded)) {
//            $this->CommentsAdded->add($commentsAdded);
//            $commentsAdded->setSolutionId($this);
//        }
//
//        return $this;
//    }
//
//    public function removeCommentsAdded(Comment $commentsAdded): static
//    {
//        if ($this->CommentsAdded->removeElement($commentsAdded)) {
//            // set the owning side to null (unless already changed)
//            if ($commentsAdded->getSolutionId() === $this) {
//                $commentsAdded->setSolutionId(null);
//            }
//        }
//
//        return $this;
//    }
//
//    /**
//     * @return Collection<int, File>
//     */
//    public function getFilesAdded(): Collection
//    {
//        return $this->FilesAdded;
//    }
//
//    public function addFilesAdded(File $filesAdded): static
//    {
//        if (!$this->FilesAdded->contains($filesAdded)) {
//            $this->FilesAdded->add($filesAdded);
//            $filesAdded->setSolutionId($this);
//        }
//
//        return $this;
//    }
//
//    public function removeFilesAdded(File $filesAdded): static
//    {
//        if ($this->FilesAdded->removeElement($filesAdded)) {
//            // set the owning side to null (unless already changed)
//            if ($filesAdded->getSolutionId() === $this) {
//                $filesAdded->setSolutionId(null);
//            }
//        }
//
//        return $this;
//    }
}
