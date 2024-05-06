<?php

namespace App\DA\Repository;

use App\DA\Entity\Comment;
use App\DA\Entity\File;
use App\DA\Entity\Lab;
use App\DA\Entity\Solution;
use App\Domain\Error\NotFoundError;
use App\Domain\Model\FileModel;
use App\Domain\Repository\IFileRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MSFileRepository extends ServiceEntityRepository implements IFileRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager, ManagerRegistry $registry
    )
    {
        parent::__construct($registry, File::class);
    }

    public function createForLab(string $path, string $name, int $labId): FileModel
    {
        $file = new File();
        $lab = $this->entityManager->getRepository(Lab::class)->find($labId);
        if ($lab == null) throw new NotFoundError("No lab with id {$labId}");

        $file->name = $name;
        $file->path = $path . $name;
        $file->lab = $lab;

        $this->entityManager->persist($file);
        $this->entityManager->flush();

        return new FileModel(
            $file->id,
            $name,
            $path,
            $labId,
            null
        );
    }

    public function createForSolution(string $path, string $name, int $solutionId): FileModel
    {
        $file = new File();
        $sol = $this->entityManager->getRepository(Solution::class)->find($solutionId);
        if ($sol == null) throw new NotFoundError("No Solution with id {$solutionId}");

        $file->name = $path . $name;
        $file->solution = $sol;

        $this->entityManager->persist($file);
        $this->entityManager->flush();

        $res = new FileModel(
            $file->id,
            $name,
            $path,
            null,
            $solutionId
        );

        return $res;
    }


    public function getById(int $id): FileModel
    {
        $file = $this->entityManager->getRepository(File::class)->find($id);
        if ($file == null) throw new NotFoundError("No file with id {$id}");

        return new FileModel(
            $id,
            $file->name,
            $file->path,
            $file->lab->id,
            $file->solution->id
        );
    }

    public function deleteByLabID(int $labId): void
    {
        $lab = $this->entityManager->getRepository(Lab::class)->find($labId);
        if ($lab == null) throw new NotFoundError("No Lab with id {$labId}");
        $files = $lab->files;

        foreach ($files as $file) {
            $this->entityManager->remove($file);
        }

        $this->entityManager->flush();
    }

    public function deleteBySolutionID(int $solId): void
    {
        $sol = $this->entityManager->getRepository(Solution::class)->find($solId);
        if ($sol == null) throw new NotFoundError("No Solution with id {$solId}");
        $files = $sol->files;

        foreach ($files as $file) {
            $this->entityManager->remove($file);
        }

        $this->entityManager->flush();
    }
}