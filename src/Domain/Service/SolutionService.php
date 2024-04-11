<?php

namespace App\Domain\Service;

use App\Domain\Model\LabState;
use App\Domain\Model\SolutionModel;
use App\Domain\Repository\IFileRepository;
use App\Domain\Repository\ISolutionRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SolutionService
{
    /**
     * @param ISolutionRepository $repository репозиторий решений
     * @param IFileRepository $fileRepository репозиторий файлов
     * @param Filesystem $fs файловая система
     */
    public function __construct(
        private readonly ISolutionRepository $repository,
//        private readonly IFileRepository     $fileRepository,
//        private readonly Filesystem          $fs
    )
    {
    }

    /**
     * @param string $description описание
     * @param LabState $state состояние
     * @param int $labId идентификатор лабораторной
     * @param int $userId идентификатор пользователя
     * @param UploadedFile[] $files файлы
     * @return int id созданного решения
     */
    public function create(
        string   $description,
        LabState $state,
        int      $labId,
        int      $userId,
        array    $files,
    ): int
    {
//        $solutionId = $this->repository->create($description, $state, $labId, $userId)->getId();
//
//        $dirName = $this->getDirName($labId, $solutionId);
//        $this->fs->mkdir($dirName);
//        foreach ($files as $file) {
//            $this->fileRepository->createForSolution($file->getClientOriginalName(), $dirName, $solutionId);
//            $file->move($dirName);
//        }
//
//        return $solutionId;
        return 1;
    }

    /**
     * @param int|null $labId id лабы, для фильтрации
     * @param LabState|null $state состояние, для фильтрации
     * @return SolutionModel[] все решения
     */
    public function getAll(?int $labId = null, ?LabState $state = null): array
    {
        return $this->repository->getAll($labId, $state);
    }

    /**
     * @param int $id id решения
     * @return SolutionModel искомое решение
     */
    public function get(int $id): SolutionModel
    {
        return $this->repository->getById($id);
    }

    /**
     * @param int $id id htitybz
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * @param int $id id лабы
     * @param SolutionModel $solution
     * @return void
     */
    public function update(int $id, SolutionModel $solution): void
    {
        $this->repository->update($id, $solution);
    }

    /**
     * @param int $id id решения
     * @param UploadedFile[] $files файлы
     * @return void
     */
    public function updateFiles(int $id, array $files): void
    {
//        $labId = $this->repository->getById($id)->getLab()->getId();
//        $dirName = $this->getDirName($labId, $id);
//
//        $this->fs->remove($dirName);
//        $this->fileRepository->deleteBySolutionID($id);
//
//        $this->fs->mkdir($dirName);
//        foreach ($files as $file) {
//            $this->fileRepository->createForSolution($file->getClientOriginalName(), $dirName, $id);
//            $file->move($dirName);
//        }
    }

}