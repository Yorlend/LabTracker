<?php

namespace App\Domain\Model;

/**
 * Сущность лабы
 */
readonly class LabModel
{
    /**
     * @param int $id id лабы
     * @param string $name название лабораторной
     * @param string $description описание лабораторной
     * @param int $groupId id группы
     * @param FileModel[] $files дескрипторы связанных файлов
     */
    public function __construct(
        private int $id,
        private string $name,
        private string $description,
        private int $groupId,
        private array $files,
    ) {
    }

    /**
     * @return int id лабы
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string название лабораторной
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string описание лабораторной
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int id группы
     */
    public function getGroupId(): int
    {
        return $this->groupId;
    }

    /**
     * @return FileModel[] дескрипторы файлов
     */
    public function getFiles(): array
    {
        return $this->files;
    }
}