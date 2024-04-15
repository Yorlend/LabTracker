<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $user_name = null;

    #[ORM\Column(length: 255)]
    private ?string $login = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $role = null;

    /**
     * @var Collection<int, Group>
     */
    #[ORM\OneToMany(targetEntity: Group::class, mappedBy: 'teacher_id')]
    private Collection $GroupsBelongs;

    #[ORM\ManyToOne(inversedBy: 'user_id')]
    private ?UserGroup $UserBelongs = null;

    /**
     * @var Collection<int, Solution>
     */
    #[ORM\OneToMany(targetEntity: Solution::class, mappedBy: 'user_id')]
    private Collection $SolutionAdded;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'user_id')]
    private Collection $CommentsAdded;

    public function __construct()
    {
        $this->GroupsBelongs = new ArrayCollection();
        $this->SolutionAdded = new ArrayCollection();
        $this->CommentsAdded = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): static
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroupsBelongs(): Collection
    {
        return $this->GroupsBelongs;
    }

    public function addGroupsBelong(Group $groupsBelong): static
    {
        if (!$this->GroupsBelongs->contains($groupsBelong)) {
            $this->GroupsBelongs->add($groupsBelong);
            $groupsBelong->setTeacherId($this);
        }

        return $this;
    }

    public function removeGroupsBelong(Group $groupsBelong): static
    {
        if ($this->GroupsBelongs->removeElement($groupsBelong)) {
            // set the owning side to null (unless already changed)
            if ($groupsBelong->getTeacherId() === $this) {
                $groupsBelong->setTeacherId(null);
            }
        }

        return $this;
    }

    public function getUserBelongs(): ?UserGroup
    {
        return $this->UserBelongs;
    }

    public function setUserBelongs(?UserGroup $UserBelongs): static
    {
        $this->UserBelongs = $UserBelongs;

        return $this;
    }

    /**
     * @return Collection<int, Solution>
     */
    public function getSolutionAdded(): Collection
    {
        return $this->SolutionAdded;
    }

    public function addSolutionAdded(Solution $solutionAdded): static
    {
        if (!$this->SolutionAdded->contains($solutionAdded)) {
            $this->SolutionAdded->add($solutionAdded);
            $solutionAdded->setUserId($this);
        }

        return $this;
    }

    public function removeSolutionAdded(Solution $solutionAdded): static
    {
        if ($this->SolutionAdded->removeElement($solutionAdded)) {
            // set the owning side to null (unless already changed)
            if ($solutionAdded->getUserId() === $this) {
                $solutionAdded->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getCommentsAdded(): Collection
    {
        return $this->CommentsAdded;
    }

    public function addCommentsAdded(Comment $commentsAdded): static
    {
        if (!$this->CommentsAdded->contains($commentsAdded)) {
            $this->CommentsAdded->add($commentsAdded);
            $commentsAdded->setUserId($this);
        }

        return $this;
    }

    public function removeCommentsAdded(Comment $commentsAdded): static
    {
        if ($this->CommentsAdded->removeElement($commentsAdded)) {
            // set the owning side to null (unless already changed)
            if ($commentsAdded->getUserId() === $this) {
                $commentsAdded->setUserId(null);
            }
        }

        return $this;
    }
}
