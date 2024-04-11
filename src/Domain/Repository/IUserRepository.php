<?php

namespace App\Domain\Repository;

use App\Domain\Model\Role;
use App\Domain\Model\UserModel;

interface IUserRepository
{
    /**
     * @param int|null $groupId id группы пользователей
     * @param Role|null $role роль пользователей
     * @return UserModel[] Все пользователи
     */
    public function getAll(?int $groupId, ?Role $role): array;

    /**
     * @param int $id
     * @return UserModel Результат поиска
     */
    public function getById(int $id): UserModel;

    /**
     * @param string $userName ФИ создаваемого пользователя
     * @param string $login логин создаваемого пользователя
     * @param string $password пароль создаваемого пользователя
     * @param Role $role роль создаваемого пользователя
     * @return UserModel
     */
    public function create(
        string $userName,
        string $login,
        string $password,
        Role   $role,
    ): UserModel;

    /**
     * @param int $id какого пользователя обновлять
     * @param UserModel $user обновленный пользователь
     * @return void
     */
    public function update(
        int       $id,
        UserModel $user,
    ): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}