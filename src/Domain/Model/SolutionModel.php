<?php

namespace App\Domain\Model;

readonly class SolutionModel
{
    /**
     * @param int $id
     * @param string $description описание решения
     * @param LabState $state статус решения
     * @param LabModel $lab лабораторная, решение к которой предложено
     * @param UserModel $user студент, отправивший лабораторную
     * @param FileModel[] $files список файлов (отчеты, исходники)
     */
    public function __construct(
        private int $id,
        private string $description,
        private LabState $state,
        private LabModel $lab,
        private UserModel $user,
        private array $files,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getState(): LabState
    {
        return $this->state;
    }

    public function getLab(): LabModel
    {
        return $this->lab;
    }

    public function getUser(): UserModel
    {
        return $this->user;
    }

    public function getFiles(): array
    {
        return $this->files;
    }


}