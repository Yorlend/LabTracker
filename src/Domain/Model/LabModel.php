<?php

namespace App\Domain\Model;

readonly class LabModel
{
    /**
     * @param int $id
     * @param string $name название лабораторной
     * @param string $description описание лабораторной
     * @param GroupModel $group группа, которой выдана лабораторная
     * @param FileModel[] $files список файлов (задание и доп. материалы)
     */
    public function __construct(
        private int $id,
        private string $name,
        private string $description,
        private GroupModel $group,
        private array $files,
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getGroup(): GroupModel
    {
        return $this->group;
    }

    public function getFiles(): array
    {
        return $this->files;
    }
}