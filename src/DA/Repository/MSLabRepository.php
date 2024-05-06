<?php

namespace App\DA\Repository;

use App\DA\Entity\Comment;
use App\DA\Entity\Group;
use App\DA\Entity\Lab;
use App\Domain\Error\NotFoundError;
use App\Domain\Model\FileModel;
use App\Domain\Model\LabModel;
use App\Domain\Repository\ILabRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MSLabRepository extends ServiceEntityRepository implements ILabRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager, ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Lab::class);
    }

    public function create(string $name, string $description, int $groupId): LabModel
    {
        $lab = new Lab();

        $group = $this->entityManager->getRepository(Group::class)->find($groupId);
        if ($group == null) throw new NotFoundError("No group with id {$groupId}");

        $lab->name = $name;
        $lab->description = $description;
        $lab->group = $group;

        $this->entityManager->persist($lab);
        $this->entityManager->flush();

        return new LabModel(
            $lab->id,
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
        $group = $this->entityManager->getRepository(Group::class)->find($groupId);
        if ($group == null) throw new NotFoundError("No group with id {$groupId}");

        $lab->name = $name;
        $lab->description = $description;
        $lab->group = $group;

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
        if ($groupId != null) {
            $data = $this->entityManager->getRepository(Lab::class)->findBy(
                ['group_id' => $groupId]
            );
        } else {
            $data = $this->entityManager->getRepository(Lab::class)->findAll();
        }

        $res = [];
        foreach ($data as $lab) {
            $files = [];
            foreach ($lab->files as $file) {
                $files[] = new FileModel(
                    $file->id,
                    $file->name,
                    $file->path,
                    $file->lab->id,
                    null
                );
            }

            $res[] = new LabModel(
                $lab->id,
                $lab->name,
                $lab->description,
                $lab->group->id,
                $files
            );
        }

        return $res;
    }

    public function getById(int $id): LabModel
    {
        $lab = $this->entityManager->getRepository(Lab::class)->find($id);
        if ($lab == null) throw new NotFoundError("No lab with id {$id}");

        $files = [];
        foreach ($lab->files as $file) {
            $files[] = new FileModel(
                $file->id,
                $file->name,
                $file->path,
                $file->lab->id,
                null
            );
        }

        return new LabModel(
            $id,
            $lab->name,
            $lab->description,
            $lab->group->id,
            $files
        );
    }

    /**
     * @throws NotFoundError
     */
    public function isTeacher(int $userId, int $labId): bool
    {
        $lab = $this->entityManager->getRepository(Lab::class)->find($labId);
        if ($lab == null) throw new NotFoundError("No lab with id {$labId}");

        $teacherId = $lab->group->teacher->id;

        return $teacherId === $userId;
    }
}