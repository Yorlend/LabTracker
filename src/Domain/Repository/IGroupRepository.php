<?php

namespace App\Domain\Repository;

use App\Domain\Model\GroupModel;


interface IGroupRepository
{
    /**
     * @return GroupModel[] Все группы
     */
    public function getAll(?int $userId): array;

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
        int   $teacherId,
    ): GroupModel;

    /**
     * @param int $id
     * @param GroupModel $group обновленная группа
     * @return void
     */
    public function update(
        int        $id,
        GroupModel $group,
    ): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * @param int $groupId id группы, в которую добавляются пользователи
     * @param array $usersId id пользователей, которых нужно добавить
     * @return void
     */
    public function addUsers(int $groupId, array $usersId): void;

    /**
     * @param int $groupId id группы, из которой удаляются пользователи
     * @param array $usersId id пользователей, которых нужно удалить
     * @return void
     */
    public function deleteUsers(int $groupId, array $usersId): void;

    /**
     * @param int $groupId id группы, в которую добавляется лаба
     * @param int $labId id добавляемой лабы
     * @return void
     */
    public function addLab(int $groupId, int $labId): void;

    /**
     * @param int $groupId id группы, из которой удаляется лаба
     * @param int $labId id удаляемой лабы
     * @return void
     */
    public function deleteLab(int $groupId, int $labId): void;
}