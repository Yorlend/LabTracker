<?php

namespace App\Domain\Repository\Mock;

use App\Domain\Model\FileModel;
use App\Domain\Model\LabModel;
use App\Domain\Repository\ILabRepository;

class LabMemRepository implements ILabRepository
{
    private array $data = [];

    public function __construct()
    {
        $this->data[] = new LabModel(
            0,
            'name',
            'desc',
            1,
            [
                new FileModel(1, 'name1', 'path1'),
            ]
        );
    }

    public function getAll(?int $groupId): array
    {
        return $this->data;
    }

    public function getById(int $id): LabModel
    {
        return $this->data[$id];
    }

    public function create(string $name, string $description, int $groupId): LabModel
    {
        $model = new LabModel(
            1,
            'name',
            'desc',
            1,
            [
                new FileModel(1, 'name1', 'path1'),
            ]
        );
        $this->data[] = $model;

        return $model;
    }

    public function update(
        int    $id,
        string $name,
        string $description,
        int    $groupId
    ): void
    {
    }

    public function delete(int $id): void
    {
    }

    public function isTeacher(int $userId, int $labId): bool
    {
        return true;
    }
}