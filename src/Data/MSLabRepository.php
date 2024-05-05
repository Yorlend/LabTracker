<?php 

namespace App\Data;

use App\Domain\Error\NotFoundError;
use App\Domain\Model\LabModel;
use App\Domain\Repository\ILabRepository;
use App\Entity\Lab;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

class MSLabRepository implements ILabRepository
    {public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(string $name, string $description, int $groupId): LabModel
    {
        $lab = new Lab();

        $lab->setName($name);
        $lab->setDescription($description);
        if ($this->entityManager->getRepository(Group::class)->find($groupId) != null)
            $lab->addGroupId($this->entityManager->getRepository(Group::class)->find($groupId));
        else throw new NotFoundError("No group with id {$groupId}");

        $this->entityManager->persist($lab);
        $this->entityManager->flush();

        return new LabModel(
            $lab->getId(),
            $name,
            $description,
            $groupId,
            array()
        );
    }

    public function update(int $id, string $name, string $description, int $groupId): void
    {
        $lab = $this->entityManager->getRepository(Lab::class)->find($id);
        if ($lab == null) throw new NotFoundError("No lab with id {$id}");
        $lab->setDescription($description);
        $lab->setName($name);
        if ($this->entityManager->getRepository(Group::class)->find($groupId) != null)
            $lab->addGroupId($this->entityManager->getRepository(Group::class)->find($groupId));
        else throw new NotFoundError("No group with id {$groupId}");

        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $lab = $this->entityManager->getRepository(Lab::class)->find($id);
        if ($lab == null) throw new NotFoundError("No lab with id {$id}");
        $this->entityManager->remove($lab);
        $this->entityManager->flush();
    }

    public function getAll(?int $groupId): array
    {
        return $this->entityManager->getRepository(Lab::class)->findBy(
            ['group_id' => $groupId]
        );
    }

    public function getById(int $id): LabModel
    {
        $lab = $this->entityManager->getRepository(Lab::class)->findOneBy(
            ['id' => $id]
        );
        if ($lab == null) throw new NotFoundError("No lab with id {$id}");

        return new LabModel(
            $id,
            $lab->getName(),
            $lab->getDescription(),
            $lab->getGroupId()->getValues()[0]->getId(),
            $lab->getFilesAdded()->getValues()
        );
    }

    /**
     * @throws NotFoundError
     */
    public function isTeacher(int $userId, int $labId): bool
    {
        $lab = $this->entityManager->getRepository(Lab::class)->findOneBy(
            ['id' => $labId]
        );

        if ($lab == null) throw new NotFoundError("No lab with id {$labId}");

        $teacherId = $lab->getGroupId()[0]->getTeacherId()->getId();

        return $teacherId === $userId;
    }
}