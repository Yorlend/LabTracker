<?php 

namespace App\Data;

use App\Domain\Model\FileModel;
use App\Domain\Repository\IFileRepository;
use App\Entity\Lab;
use App\Entity\File;
use App\Entity\Solution;
use Doctrine\ORM\EntityManagerInterface;

class MSFileRepository implements IFileRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function createForLab(string $path, string $name, int $labId): FileModel
    {
        $file = new File();
        $file->setName($path + $name);
        $file->setLabId($this->entityManager->getRepository(Lab::class)->find($labId));

        $this->entityManager->persist($file);
        $this->entityManager->flush();

        return new FileModel(
            $file->getId(),
            $name,
            $path,
            $file->getLabId()->getId(),
            null
        );
    }

    public function createForSolution(string $path, string $name, int $solutionId): FileModel
    {
        $file = new File();
        $file->setName($path + $name);
        $file->setLabId($this->entityManager->getRepository(Solution::class)->find($solutionId));

        $this->entityManager->persist($file);
        $this->entityManager->flush();

        return new FileModel(
            $file->getId(),
            $name,
            $path,
            null,
            $file->getSolutionId()->getId()
        );
    }



    public function getById(int $id): FileModel
    {
        $file = $this->entityManager->getRepository(File::class)->findOneBy(
            ['id' == $id]
        );

        return new FileModel(
            $id,
            $file->getName(),
            $file->getName(),
            $file->getLabId()->getId(),
            $file->getSolutionId()->getId()
        );
    }

    public function deleteByLabID(int $labId): void
    {
        $lab = $this->entityManager->getRepository(Lab::class)->findOneBy(
            ['id' == $labId]
        );

        foreach ($lab->getFilesAdded()->getValues() as &$file)
            $lab->removeFilesAdded($file);
        
        $this->entityManager->flush();
    }

    public function deleteBySolutionID(int $labId): void
    {
        $sol = $this->entityManager->getRepository(Solution::class)->findOneBy(
            ['id' == $labId]
        );

        foreach ($sol->getFilesAdded()->getValues() as &$file)
            $sol->removeFilesAdded($file);
        
        $this->entityManager->flush();
    }
}