<?php

namespace App\Domain\Repository\Mock;

use App\Domain\Model\GroupModel;
use App\Domain\Repository\IGroupRepository;

class GroupMemRepository implements IGroupRepository
{
    private array $data = [];

    public function __construct()
    {
        $this->data[] = new GroupModel(
            0,
            "group1",
            [1, 2,],
            3
        );
    }

    public function getAll(?int $userId): array
    {
        return $this->data;
    }

    public function getById(int $id): GroupModel
    {
        return $this->data[$id];
    }

    public function create(string $name, array $usersIds, int $teacherId): GroupModel
    {
        $group = new GroupModel(count($this->data), $name, $usersIds, $teacherId);
        $this->data[] = $group;

        return $group;
    }

    public function update(int $id, string $name, int $teacherId): void
    {
    }

    public function delete(int $id): void
    {
    }

    public function addUsers(int $groupId, array $usersId): void
    {
    }

    public function deleteUsers(int $groupId, array $usersId): void
    {
    }

    public function addLab(int $groupId, int $labId): void
    {
    }

    public function deleteLab(int $groupId, int $labId): void
    {
    }
}