<?php

namespace App\Domain\Repository\Mock;

use App\Domain\Model\CommentModel;
use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
use App\Domain\Repository\ICommentRepository;

class CommentMemRepository implements ICommentRepository
{
    private array $data = [];

    public function __construct()
    {
        $this->data[] = new CommentModel(
            1,
            'text',
            'now',
            new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
        );
    }

    public function create(int $solutionId, string $text): CommentModel
    {
        $model = new CommentModel(
            1,
            'text',
            'now',
            new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
        );
        $this->data[] = $model;

        return $model;
    }

    public function update(int $id, string $text): void
    {
    }

    public function delete(int $id): void
    {
    }

    public function getBySolutionId(int $solutionId): array
    {
        return $this->data;
    }
}