<?php

namespace App\Domain\Model;

readonly class FileModel
{
    /**
     * @param int $id
     * @param string $name Название файла
     * @param string $path Путь к файлу
     */
    public function __construct(
        private int $id,
        private string $name,
        private string $path,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}