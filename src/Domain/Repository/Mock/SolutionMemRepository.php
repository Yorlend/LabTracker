<?php

namespace App\Domain\Repository\Mock;

use App\Domain\Model\FileModel;
use App\Domain\Model\Role;
use App\Domain\Model\SolutionModel;
use App\Domain\Model\SolutionState;
use App\Domain\Model\UserModel;
use App\Domain\Repository\ISolutionRepository;

class SolutionMemRepository implements ISolutionRepository
{
    private array $data = [];

    public function __construct()
    {
        $this->data[] = new SolutionModel(
            1,
            'desc',
            SolutionState::Checking,
            1,
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1', 'path1'),
                new FileModel(2, 'name2', 'path2'),
            ],
        );
    }

    public function getAll(?int $labId, ?SolutionState $state): array
    {
        return $this->data;
    }

    public function getById(int $id): SolutionModel
    {
        return $this->data[$id];
    }

    public function create(string $description, SolutionState $state, int $labId, int $userId,): SolutionModel
    {
        $model = new SolutionModel(
            1,
            'desc',
            SolutionState::Checking,
            1,
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1', 'path1'),
                new FileModel(2, 'name2', 'path2'),
            ],
        );
        $this->data[] = $model;

        return $model;
    }

    public function update(int $id, string $description, SolutionState $state): void
    {
    }

    public function delete(int $id): void
    {
    }
}