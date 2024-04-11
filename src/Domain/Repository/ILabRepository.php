<?php

namespace App\Domain\Repository;

use App\Domain\Model\LabModel;

interface ILabRepository
{
    /**
     * @param int|null $groupId id группы, для фильтрации
     * @return LabModel[] Все лабораторные
     */
    public function getAll(?int $groupId): array;

    /**
     * @param int $id
     * @return LabModel Результат поиска
     */
    public function getById(int $id): LabModel;

    /**
     * @param string $name название
     * @param string $description описание
     * @param int $groupId идентификатор группы
     * @return LabModel
     */
    public function create(
        string $name,
        string $description,
        int    $groupId,
    ): LabModel;

    /**
     * @param int $id
     * @param LabModel $lab обновленная лабораторная
     * @return void
     */
    public function update(
        int      $id,
        LabModel $lab,
    ): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}