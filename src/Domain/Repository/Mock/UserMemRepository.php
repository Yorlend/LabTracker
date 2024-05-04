<?php

namespace App\Domain\Repository\Mock;

use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
use App\Domain\Repository\IUserRepository;

class UserMemRepository implements IUserRepository
{
    private array $data = [];

    public function __construct()
    {
        $this->data[] = new UserModel(0, 'name1', 'login1', 'pass1', Role::Student);
    }

    public function getAll(?int $groupId, ?Role $role): array
    {
        return $this->data;
    }

    public function getById(int $id): UserModel
    {
        return $this->data[$id];
    }

    public function create(string $userName, string $login, string $password, Role $role): UserModel
    {
        $user = new UserModel(count($this->data), $userName, $login, $password, $role);
        $this->data[] = $user;

        return $user;
    }

    public function update(int $id, UserModel $user): void
    {
        $this->data[$id] = $user;
    }

    public function delete(int $id): void
    {
        unset($this->data[$id]);
    }

    public function getByLogin(string $login): UserModel
    {
        return $this->data[0];
    }
}