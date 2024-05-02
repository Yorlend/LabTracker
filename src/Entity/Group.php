<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'GroupsBelongs')]
    private ?User $teacher_id = null;

    #[ORM\OneToOne(mappedBy: 'group_id', cascade: ['persist', 'remove'])]
    private ?UserGroup $GroupMatch = null;

    /**
     * @var Collection<int, Lab>
     */
    #[ORM\ManyToMany(targetEntity: Lab::class, mappedBy: 'group_id')]
    private Collection $IssuedLabs;

    public function __construct()
    {
        $this->IssuedLabs = new ArrayCollection();
    }

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

    public function getTeacherId(): ?User
    {
        return $this->teacher_id;
    }

    public function setTeacherId(?User $teacher_id): static
    {
        $this->teacher_id = $teacher_id;

        return $this;
    }

    public function getGroupMatch(): ?UserGroup
    {
        return $this->GroupMatch;
    }

    public function setGroupMatch(?UserGroup $GroupMatch): static
    {
        // unset the owning side of the relation if necessary
        if ($GroupMatch === null && $this->GroupMatch !== null) {
            $this->GroupMatch->setGroupId(null);
        }

        // set the owning side of the relation if necessary
        if ($GroupMatch !== null && $GroupMatch->getGroupId() !== $this) {
            $GroupMatch->setGroupId($this);
        }

        $this->GroupMatch = $GroupMatch;

        return $this;
    }

    /**
     * @return Collection<int, Lab>
     */
    public function getIssuedLabs(): Collection
    {
        return $this->IssuedLabs;
    }

    public function addIssuedLab(Lab $issuedLab): static
    {
        if (!$this->IssuedLabs->contains($issuedLab)) {
            $this->IssuedLabs->add($issuedLab);
            $issuedLab->addGroupId($this);
        }

        return $this;
    }

    public function removeIssuedLab(Lab $issuedLab): static
    {
        if ($this->IssuedLabs->removeElement($issuedLab)) {
            $issuedLab->removeGroupId($this);
        }

        return $this;
    }
}
