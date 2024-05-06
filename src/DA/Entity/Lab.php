<?php

namespace App\DA\Entity;

use App\DA\Repository\MSLabRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MSLabRepository::class)]
class Lab
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(length: 255)]
    public ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Group::class, inversedBy: 'labs')]
    #[ORM\JoinColumn(name: 'group_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    public ?Group $group = null;

    /**
     * @var Collection<int, Solution>
     */
    #[ORM\OneToMany(targetEntity: Solution::class, mappedBy: 'lab')]
    public Collection $solutions;

    /**
     * @var Collection<int, File>
     */
    #[ORM\OneToMany(targetEntity: File::class, mappedBy: 'lab')]
    public Collection $files;


    public function __construct()
    {
        $this->solutions = new ArrayCollection();
        $this->files = new ArrayCollection();
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
//    public function getDescription(): ?string
//    {
//        return $this->description;
//    }
//
//    public function setDescription(string $description): static
//    {
//        $this->description = $description;
//
//        return $this;
//    }
//
//    public function getGroup(): ?Group
//    {
//        return $this->group;
//    }
//
//    public function addGroupId(Group $groupId): static
//    {
//        if (!$this->group_id->contains($groupId)) {
//            $this->group_id->add($groupId);
//        }
//
//        return $this;
//    }
//
//    public function removeGroupId(Group $groupId): static
//    {
//        $this->group_id->removeElement($groupId);
//
//        return $this;
//    }
//
//    /**
//     * @return Collection<int, Solution>
//     */
//    public function getSolutionsBelongs(): Collection
//    {
//        return $this->SolutionsBelongs;
//    }
//
//    public function addSolutionsBelong(Solution $solutionsBelong): static
//    {
//        if (!$this->SolutionsBelongs->contains($solutionsBelong)) {
//            $this->SolutionsBelongs->add($solutionsBelong);
//            $solutionsBelong->setLabId($this);
//        }
//
//        return $this;
//    }
//
//    public function removeSolutionsBelong(Solution $solutionsBelong): static
//    {
//        if ($this->SolutionsBelongs->removeElement($solutionsBelong)) {
//            // set the owning side to null (unless already changed)
//            if ($solutionsBelong->getLabId() === $this) {
//                $solutionsBelong->setLabId(null);
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
//            $filesAdded->setLabId($this);
//        }
//
//        return $this;
//    }
//
//    public function removeFilesAdded(File $filesAdded): static
//    {
//        if ($this->FilesAdded->removeElement($filesAdded)) {
//            // set the owning side to null (unless already changed)
//            if ($filesAdded->getLabId() === $this) {
//                $filesAdded->setLabId(null);
//            }
//        }
//
//        return $this;
//    }
}
