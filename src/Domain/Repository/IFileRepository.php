<?php

namespace App\Domain\Repository;

use App\Domain\Model\FileModel;

interface IFileRepository
{
    /**
     * @return FileModel[] Все файлы
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return FileModel Результат поиска
     */
    public function getById(int $id): FileModel;

    /**
     * @param string $name имя
     * @param string $path путь
     * @param int $labId id лабы, к которой относится файл
     * @return FileModel
     */
    public function createForLab(
        string $name,
        string $path,
        int    $labId
    ): FileModel;

    /**
     * @param string $name имя
     * @param string $path путь
     * @param int $solutionId id решения, к которому относится файл
     * @return FileModel
     */
    public function createForSolution(
        string $name,
        string $path,
        int    $solutionId
    ): FileModel;

    /**
     * @param int $id
     * @param FileModel $file обновленный файл
     * @return void
     */
    public function update(
        int       $id,
        FileModel $file,
    ): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * @param int $labId id лабы, для которой удаляются файлы
     * @return void
     */
    public function deleteByLabID(int $labId): void;

    /**
     * @param int $labId id решения, для которого удаляются файлы
     * @return void
     */
    public function deleteBySolutionID(int $labId): void;
}