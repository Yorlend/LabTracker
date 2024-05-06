<?php

namespace App\Domain\Service;

use App\Domain\Model\FileModel;
use App\Domain\Model\LabModel;
use App\Domain\Repository\IFileRepository;
use App\Domain\Repository\ILabRepository;
use App\Domain\Storage\ILabFileStorage;

/**
 * Сервис для работы с лабами
 */
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
     * Создать лабу
     *
     * @param string $name название
     * @param string $description описание
     * @param int $groupId идентификатор группы
     * @return int id созданной лабы
     */
    public function create(
        string $name,
        string $description,
        int    $groupId
    ): int
    {
        return $this->repository->create($name, $description, $groupId)->getId();
    }

    /**
     * Получить все лабы
     *
     * @param int|null $groupId id группы, для фильтрации
     * @return LabModel[] все лабораторные
     */
    public function getAll(?int $groupId = null): array
    {
        return $this->repository->getAll($groupId);
    }

    /**
     * Получить лабу по id
     *
     * @param int $id id лабы
     * @return LabModel искомая лаба
     */
    public function get(int $id): LabModel
    {
        return $this->repository->getById($id);
    }

    /**
     * Удалить лабу
     *
     * @param int $id id лабы
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * Обновить лабу
     *
     * @param int $id id лабы
     * @param string $name имя лабы
     * @param string $description описание лабы
     * @param int $groupId id группы
     * @return void
     */
    public function update(int $id, string $name, string $description, int $groupId): void
    {
        $this->repository->update($id, $name, $description, $groupId);
    }

    /**
     * Обновить файлы лабы
     *
     * @param int $id id лабы
     * @param FileModel[] $files дескрипторы файлов во временном хранилище
     * @return void
     */
    public function updateFiles(int $id, array $files): void
    {
        $groupId = $this->repository->getById($id)->getGroupId();
//        $this->fileStorage->clearLabFiles($groupId, $id);
        $this->fileRepository->deleteByLabID($id);


        foreach ($files as $file) {
            $constPath = $this->fileStorage->save($groupId, $id, $file);
            $this->fileRepository->createForLab($constPath, $file->getName(), $id);
        }
    }

    /**
     * Проверка id преподавателя
     *
     * @param int $userId id предполагаемого преподавателя
     * @param int $labId id лабы
     * @return bool является ли пользователь преподавателем
     */
    public function isTeacher(int $userId, int $labId): bool{
        return $this->repository->isTeacher($userId, $labId);
    }
}