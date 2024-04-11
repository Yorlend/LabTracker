<?php

namespace App\Domain\Service;

use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
use App\Domain\Repository\IUserRepository;

class UserService
{

    /**
     * @param IUserRepository $repository репозиторий пользователей
     */
    public function __construct(private readonly IUserRepository $repository)
    {
    }

    /**
     * @param string $userName ФИ создаваемого пользователя
     * @param string $login логин создаваемого пользователя
     * @param string $password пароль создаваемого пользователя
     * @param Role $role роль создаваемого пользователя
     * @return int id созданного пользователя
     */
    public function create(
        string $userName,
        string $login,
        string $password,
        Role   $role,
    ): int
    {
        return $this->repository->create($userName, $login, $password, $role)->getId();
    }

    /**
     * @param int|null $groupId id группы пользователей, для фильтрации
     * @param Role|null $role роль пользователей, для фильтрации
     * @return UserModel[] все пользователи
     */
    public function getAll(?int $groupId = null, ?Role $role = null): array
    {
        return $this->repository->getAll($groupId, $role);
    }

    /**
     * @param int $id id пользователя
     * @return UserModel искомый пользователь
     */
    public function get(int $id): UserModel
    {
        return $this->repository->getById($id);
    }

    /**
     * @param int $id id пользователя
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * @param int $id id пользователя
     * @param UserModel $user обновленный пользователь
     * @return void
     */
    public function update(int $id, UserModel $user): void
    {
        $this->repository->update($id, $user);
    }
}