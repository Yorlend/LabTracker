<?php

namespace App\Domain\Service;

use App\Domain\Model\LabModel;
use App\Domain\Repository\IFileRepository;
use App\Domain\Repository\ILabRepository;
class LabService
{
    /**
     * @param ILabRepository $repository репозиторий лаб
     * @param IFileRepository $fileRepository репозиторий файлов
     */
    public function __construct(
        private readonly ILabRepository  $repository,
//        private readonly IFileRepository $fileRepository,
//        private readonly ILabFileStorage $fileStorage,
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
//        $labId = $this->repository->create($name, $description, $groupId)->getId();
//
//        foreach ($files as $path) {
//            $nodes = explode('/', $path);
//            $name = end($nodes);
//            $this->fileRepository->createForLab($name,$dirName . $name, $labId);
//        }
//        $this->fileStorage->s
//
//        return $labId;
        return 1;
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
//        $groupId = $this->repository->getById($id)->getGroup()->getId();
//        $dirName = $this->getDirName($groupId, $id);
//
//        $this->deleteDirectory($dirName);
//        $this->fileRepository->deleteByLabID($id);
//
//
//        mkdir($dirName);
//        foreach ($files as $path) {
//            $nodes = explode('/', $path);
//            $name = end($nodes);
//            $this->fileRepository->createForLab($name, $path, $id);
//            copy($path, $dirName . $name);
//        }
    }
}