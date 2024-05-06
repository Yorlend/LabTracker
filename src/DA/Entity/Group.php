<?php

namespace App\DA\Entity;

use App\DA\Repository\MSGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MSGroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'studyGroups')]
    #[ORM\JoinColumn(name: 'teacher_id', referencedColumnName: 'id')]
    public ?User $teacher = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'groups')]
//    #[ORM\JoinTable(name: 'users_groups')]
    public Collection $users;

    /**
     * @var Collection<int, Lab>
     */
    #[ORM\OneToMany(targetEntity: Lab::class, mappedBy: 'group')]
    public Collection $labs;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->labs = new ArrayCollection();
    }

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
//    public function getTeacherId(): ?User
//    {
//        return $this->teacher_id;
//    }
//
//    public function setTeacherId(?User $teacher_id): static
//    {
//        $this->teacher_id = $teacher_id;
//
//        return $this;
//    }
//
//    public function getGroupMatch(): ?UserGroup
//    {
//        return $this->GroupMatch;
//    }
//
//    public function setGroupMatch(?UserGroup $GroupMatch): static
//    {
//        // unset the owning side of the relation if necessary
//        if ($GroupMatch === null && $this->GroupMatch !== null) {
//            $this->GroupMatch->setGroupId(null);
//        }
//
//        // set the owning side of the relation if necessary
//        if ($GroupMatch !== null && $GroupMatch->getGroupId() !== $this) {
//            $GroupMatch->setGroupId($this);
//        }
//
//        $this->GroupMatch = $GroupMatch;
//
//        return $this;
//    }
//
//    /**
//     * @return Collection<int, Lab>
//     */
//    public function getIssuedLabs(): Collection
//    {
//        return $this->IssuedLabs;
//    }
//
//    public function addIssuedLab(Lab $issuedLab): static
//    {
//        if (!$this->IssuedLabs->contains($issuedLab)) {
//            $this->IssuedLabs->add($issuedLab);
//            $issuedLab->addGroupId($this);
//        }
//
//        return $this;
//    }
//
//    public function removeIssuedLab(Lab $issuedLab): static
//    {
//        if ($this->IssuedLabs->removeElement($issuedLab)) {
//            $issuedLab->removeGroupId($this);
//        }
//
//        return $this;
//    }
}
