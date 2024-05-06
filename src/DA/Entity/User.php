<?php

namespace App\DA\Entity;

use App\DA\Repository\MSUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MSUserRepository::class)]
#[UniqueEntity('login')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $user_name = null;

    #[ORM\Column(length: 255, unique: true)]
    public ?string $login = null;

    #[ORM\Column(length: 255)]
    public ?string $password = null;

    #[ORM\Column(type: Types::SMALLINT)]
    public ?int $role = null;

    /**
     * @var Collection<int, Group>
     */
    #[ORM\OneToMany(targetEntity: Group::class, mappedBy: 'teacher')]
    public Collection $studyGroups;

    /**
     * @var Collection<int, Group>
     */
    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'users')]
    #[ORM\JoinTable(name: 'users_groups')]
    public Collection $groups;

    /**
     * @var Collection<int, Solution>
     */
    #[ORM\OneToMany(targetEntity: Solution::class, mappedBy: 'user')]
    public Collection $solutions;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'user')]
    public Collection $comments;

    public function __construct()
    {
        $this->studyGroups = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->solutions = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

//    public function addGroupsBelong(Group $groupsBelong): static
//    {
//        if (!$this->GroupsBelongs->contains($groupsBelong)) {
//            $this->GroupsBelongs->add($groupsBelong);
//            $groupsBelong->setTeacherId($this);
//        }
//
//        return $this;
//    }
//
//    public function removeGroupsBelong(Group $groupsBelong): static
//    {
//        if ($this->GroupsBelongs->removeElement($groupsBelong)) {
//            // set the owning side to null (unless already changed)
//            if ($groupsBelong->getTeacherId() === $this) {
//                $groupsBelong->setTeacherId(null);
//            }
//        }
//
//        return $this;
//    }
//
//    public function getUserBelongs(): ?UserGroup
//    {
//        return $this->UserBelongs;
//    }
//
//    public function setUserBelongs(?UserGroup $UserBelongs): static
//    {
//        $this->UserBelongs = $UserBelongs;
//
//        return $this;
//    }
//
//    /**
//     * @return Collection<int, Solution>
//     */
//    public function getSolutionAdded(): Collection
//    {
//        return $this->SolutionAdded;
//    }
//
//    public function addSolutionAdded(Solution $solutionAdded): static
//    {
//        if (!$this->SolutionAdded->contains($solutionAdded)) {
//            $this->SolutionAdded->add($solutionAdded);
//            $solutionAdded->setUserId($this);
//        }
//
//        return $this;
//    }
//
//    public function removeSolutionAdded(Solution $solutionAdded): static
//    {
//        if ($this->SolutionAdded->removeElement($solutionAdded)) {
//            // set the owning side to null (unless already changed)
//            if ($solutionAdded->getUserId() === $this) {
//                $solutionAdded->setUserId(null);
//            }
//        }
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
//            $commentsAdded->setUserId($this);
//        }
//
//        return $this;
//    }
//
//    public function removeCommentsAdded(Comment $commentsAdded): static
//    {
//        if ($this->CommentsAdded->removeElement($commentsAdded)) {
//            // set the owning side to null (unless already changed)
//            if ($commentsAdded->getUserId() === $this) {
//                $commentsAdded->setUserId(null);
//            }
//        }
//
//        return $this;
//    }
}
