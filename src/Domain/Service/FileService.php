<?php

namespace App\Domain\Service;

use App\Domain\Model\FileModel;
use App\Domain\Repository\IFileRepository;

class FileService
{
    /**
     * @param IFileRepository $repository репозиторий файлов
     */
    public function __construct(private readonly IFileRepository $repository)
    {
    }

    /**
     * @param int $id id файла
     * @return FileModel искомый файл
     */
    public function get(int $id): FileModel
    {
        return $this->repository->getById($id);
    }
}