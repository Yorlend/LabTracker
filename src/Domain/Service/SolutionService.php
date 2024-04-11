<?php

namespace App\Domain\Service;

use App\Domain\Model\LabState;
use App\Domain\Model\SolutionModel;
use App\Domain\Repository\IFileRepository;
use App\Domain\Repository\ISolutionRepository;
use App\Domain\Storage\ISolutionFileStorage;

class SolutionService
{
    /**
     * @param ISolutionRepository $repository репозиторий решений
     * @param IFileRepository $fileRepository репозиторий файлов
     * @param ISolutionFileStorage $fileStorage хранилище файлов
     */
    public function __construct(
        private readonly ISolutionRepository  $repository,
        private readonly IFileRepository      $fileRepository,
        private readonly ISolutionFileStorage $fileStorage
    )
    {
    }

    /**
     * @param string $description описание
     * @param LabState $state состояние
     * @param int $labId идентификатор лабораторной
     * @param int $userId идентификатор пользователя
     * @param string[] $files файлы
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
        $solutionId = $this->repository->create($description, $state, $labId, $userId)->getId();

        foreach ($files as $path) {
            $nodes = explode('/', $path);
            $name = end($nodes);
            $this->fileRepository->createForSolution($name, $solutionId);
        }
        $this->fileStorage->save($labId, $solutionId, $files);

        return $solutionId;
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
     * @param string[] $files файлы
     * @return void
     */
    public function updateFiles(int $id, array $files): void
    {
        $labId = $this->repository->getById($id)->getLab()->getId();
        $this->fileStorage->clearSolutionFiles($labId, $id);
        $this->fileRepository->deleteBySolutionID($id);

        foreach ($files as $path) {
            $nodes = explode('/', $path);
            $name = end($nodes);
            $this->fileRepository->createForSolution($name, $id);
        }
        $this->fileStorage->save($labId, $id, $files);
    }

    /**
     * @param int $id id решения
     * @param string $name имя файла
     * @return string путь к файлу
     */
    public function getFile(int $id, string $name): string
    {
        $labId = $this->repository->getById($id)->getLab()->getId();

        return $this->fileStorage->getFilePath($labId, $id, $name);
    }

}