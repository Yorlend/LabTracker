<?php

namespace App\Domain\Service;

use App\Domain\Model\FileModel;
use App\Domain\Repository\IFileRepository;

/**
 * Сервис для работы с дескрипторами файлов
 */
class FileService
{
    /**
     * @param IFileRepository $fileRepository репозиторий файлов
     */
    public function __construct(
        private readonly IFileRepository $fileRepository,
    )
    {
    }

    /**
     * Получить дескриптор файлов
     *
     * @param int $fileId id  файла
     * @return FileModel дескриптор файла
     */
    public function getFile(int $fileId): FileModel
    {
        return $this->fileRepository->getById($fileId);
    }
}