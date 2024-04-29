<?php

namespace App\Domain\Repository\Mock;

use App\Domain\Model\FileModel;
use App\Domain\Repository\IFileRepository;

class FileMemRepository implements IFileRepository
{
    private array $data = [];

    public function __construct()
    {
        $this->data[] = new FileModel(1, 'main', '/var/www/symfony/test_storage/lab/1/0/Lection_11_2023.pdf');
    }

    public function getAll(): array
    {
        return $this->data;
    }

    public function getById(int $id): FileModel
    {
        return $this->data[0];
    }

    public function createForLab(string $path, string $name, int $labId,): FileModel
    {
        $model = new FileModel(1, 'name1', 'path1');
        $this->data[] = $model;

        return $model;
    }

    public function createForSolution(string $path, string $name, int $solutionId,): FileModel
    {
        $model = new FileModel(1, 'name1', 'path1');
        $this->data[] = $model;

        return $model;
    }

    public function update(int $id, FileModel $file,): void
    {
    }

    public function delete(int $id): void
    {
    }

    public function deleteByLabID(int $labId): void
    {
    }

    public function deleteBySolutionID(int $labId): void
    {
    }
}