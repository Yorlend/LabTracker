<?php

namespace App\Domain\Service;

use App\Domain\Model\LabModel;
use App\Domain\Repository\IFileRepository;
use App\Domain\Repository\ILabRepository;
use App\Domain\Storage\ILabFileStorage;

class LabService
{
    /**
     * @param ILabRepository $repository репозиторий лаб
     * @param IFileRepository $fileRepository репозиторий файлов
     * @param ILabFileStorage $fileStorage хранилище файлов
     */
    public function __construct(
        private readonly ILabRepository  $repository,
        private readonly IFileRepository $fileRepository,
        private readonly ILabFileStorage $fileStorage,
    )
    {
    }

    /**
     * @param string $name название
     * @param string $description описание
     * @param int $groupId идентификатор группы
     * @param string[] $files пути к файлам
     * @return int id созданной лабы
     */
    public function create(
        string $name,
        string $description,
        int    $groupId,
        array  $files,
    ): int
    {
        $labId = $this->repository->create($name, $description, $groupId)->getId();

        foreach ($files as $path) {
            $nodes = explode('/', $path);
            $name = end($nodes);
            $this->fileRepository->createForLab($name, $labId);
        }
        $this->fileStorage->save($groupId, $labId, $files);

        return $labId;
    }

    /**
     * @param int|null $groupId id группы, для фильтрации
     * @return LabModel[] все лабораторные
     */
    public function getAll(?int $groupId = null): array
    {
        return $this->repository->getAll($groupId);
    }

    /**
     * @param int $id id лабы
     * @return LabModel искомая лаба
     */
    public function get(int $id): LabModel
    {
        return $this->repository->getById($id);
    }

    /**
     * @param int $id id лабы
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * @param int $id id лабы
     * @param LabModel $lab обновленная лабораторная
     * @return void
     */
    public function update(int $id, LabModel $lab): void
    {
        $this->repository->update($id, $lab);
    }

    /**
     * @param int $id id лабы
     * @param string[] $files файлы
     * @return void
     */
    public function updateFiles(int $id, array $files): void
    {
        $groupId = $this->repository->getById($id)->getGroup()->getId();
        $this->fileStorage->clearLabFiles($groupId, $id);
        $this->fileRepository->deleteByLabID($id);

        foreach ($files as $path) {
            $nodes = explode('/', $path);
            $name = end($nodes);
            $this->fileRepository->createForLab($name, $id);
        }
        $this->fileStorage->save($groupId, $id, $files);
    }

    /**
     * @param int $id id лабы
     * @param string $name имя файла
     * @return string путь к файлу
     */
    public function getFile(int $id, string $name): string
    {
        $groupID = $this->repository->getById($id)->getGroup()->getId();

        return $this->fileStorage->getFilePath($groupID, $id, $name);
    }
}