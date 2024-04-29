<?php

namespace App\Domain\Repository;

use App\Domain\Model\GroupModel;


/**
 * Интерфейс репозитория групп
 */
interface IGroupRepository
{
    /**
     * Получить все группы
     *
     * @return GroupModel[] Все группы
     */
    public function getAll(?int $userId): array;

    /**
     * Получить группу по id
     *
     * @param int $id
     * @return GroupModel Результат поиска
     */
    public function getById(int $id): GroupModel;


    /**
     * Создать группу
     *
     * @param string $name имя группы
     * @param int[] $users идентификаторы студентов
     * @param int $teacherId идентификатор преподавателя
     * @return GroupModel
     */
    public function create(
        string $name,
        array  $users,
        int    $teacherId,
    ): GroupModel;

    /**
     * Обновить группу
     *
     * @param int $id id пользователя
     * @param string $name имя группы
     * @param int $teacherId id преподавателя
     * @return void
     */
    public function update(
        int    $id,
        string $name,
        int    $teacherId
    ): void;

    /**
     * Удалить группу
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Добавить ученика в группу
     *
     * @param int $groupId id группы, в которую добавляются пользователи
     * @param array $usersId id пользователей, которых нужно добавить
     * @return void
     */
    public function addUsers(int $groupId, array $usersId): void;

    /**
     * Удалить ученика из группы
     *
     * @param int $groupId id группы, из которой удаляются пользователи
     * @param array $usersId id пользователей, которых нужно удалить
     * @return void
     */
    public function deleteUsers(int $groupId, array $usersId): void;

    /**
     * Добавить лабу в группу
     *
     * @param int $groupId id группы, в которую добавляется лаба
     * @param int $labId id добавляемой лабы
     * @return void
     */
    public function addLab(int $groupId, int $labId): void;

    /**
     * Удалить лабу из группы
     *
     * @param int $groupId id группы, из которой удаляется лаба
     * @param int $labId id удаляемой лабы
     * @return void
     */
    public function deleteLab(int $groupId, int $labId): void;
}