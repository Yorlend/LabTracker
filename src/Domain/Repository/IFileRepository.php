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
     * @return FileModel
     */
    public function create(
        string $name,
        string $path,
    ): FileModel;

    /**
     * @param int $id
     * @param FileModel $file обновленный файл
     * @return void
     */
    public function update(
        int $id,
        FileModel $file,
    ): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}