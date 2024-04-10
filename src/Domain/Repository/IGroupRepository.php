<?php

namespace App\Domain\Repository;

use App\Domain\Model\GroupModel;

interface IGroupRepository
{
    /**
     * @return GroupModel[] Все группы
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return GroupModel Результат поиска
     */
    public function getById(int $id): GroupModel;


    /**
     * @param int[] $users идентификаторы студентов
     * @param int $teacherId идентификатор преподавателя
     * @return GroupModel
     */
    public function create(
        array $users,
        int $teacherId,
    ): GroupModel;

    /**
     * @param int $id
     * @param GroupModel $group обновленная группа
     * @return void
     */
    public function update(
        int $id,
        GroupModel $group,
    ): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}