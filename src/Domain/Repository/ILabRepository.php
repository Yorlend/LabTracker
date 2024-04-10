<?php

namespace App\Domain\Repository;

use App\Domain\Model\FileModel;
use App\Domain\Model\LabModel;

interface ILabRepository
{
    /**
     * @return LabModel[] Все лабораторные
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return LabModel Результат поиска
     */
    public function getById(int $id): LabModel;

    /**
     * @param string $name название
     * @param string $description описание
     * @param string $groupId идентификатор группы
     * @param FileModel[] $files список файлов
     * @return LabModel
     */
    public function create(
        string $name,
        string $description,
        string $groupId,
        array $files,
    ): LabModel;

    /**
     * @param int $id
     * @param LabModel $lab обновленная лабораторная
     * @return void
     */
    public function update(
        int $id,
        LabModel $lab,
    ): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}