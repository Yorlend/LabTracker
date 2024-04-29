<?php

namespace App\Domain\Service;

use App\Domain\Model\FileModel;
use App\Domain\Model\SolutionModel;
use App\Domain\Model\SolutionState;
use App\Domain\Repository\IFileRepository;
use App\Domain\Repository\ISolutionRepository;
use App\Domain\Storage\ISolutionFileStorage;

/**
 * Сервис для работы с решениями
 */
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
     * Создать решение
     *
     * @param string $description описание
     * @param SolutionState $state состояние
     * @param int $labId идентификатор лабораторной
     * @param int $userId идентификатор пользователя
     * @return int id созданного решения
     */
    public function create(
        string        $description,
        SolutionState $state,
        int           $labId,
        int           $userId,
    ): int
    {
        return $this->repository->create($description, $state, $labId, $userId)->getId();
    }

    /**
     * Получить все решения
     *
     * @param int|null $labId id лабы, для фильтрации
     * @param SolutionState|null $state состояние, для фильтрации
     * @return SolutionModel[] все решения
     */
    public function getAll(?int $labId = null, ?SolutionState $state = null): array
    {
        return $this->repository->getAll($labId, $state);
    }

    /**
     * Получить решение по id
     *
     * @param int $id id решения
     * @return SolutionModel искомое решение
     */
    public function get(int $id): SolutionModel
    {
        return $this->repository->getById($id);
    }

    /**
     * Удалить решение
     *
     * @param int $id id htitybz
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * Обновить решение
     *
     * @param int $id id лабы
     * @param string $description описание
     * @param SolutionState $state состояние
     * @return void
     */
    public function update(int $id, string $description, SolutionState $state): void
    {
        $this->repository->update($id, $description, $state);
    }

    /**
     * Обновить файлы решения
     *
     * @param int $id id решения
     * @param FileModel[] $files дескрипторы файлов во временном хранилище
     * @return void
     */
    public function updateFiles(int $id, array $files): void
    {
        $labId = $this->repository->getById($id)->getLabId();
        $this->fileStorage->clearSolutionFiles($labId, $id);
        $this->fileRepository->deleteBySolutionID($id);

        foreach ($files as $file) {
            $constPath = $this->fileStorage->save($labId, $id, $file);
            $this->fileRepository->createForSolution($constPath, $file->getName(), $id);
        }
    }

}