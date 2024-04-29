<?php

namespace App\Domain\Model;

/**
 * Сущность решения
 */
readonly class SolutionModel
{
    /**
     * @param int $id id решения
     * @param string $description описание решения
     * @param SolutionState $state статус решения
     * @param int $labId id лабы
     * @param UserModel $user пользователь, загрузивший решение
     * @param FileModel[] $files дескрипторы связанных файлов
     */
    public function __construct(
        private int           $id,
        private string        $description,
        private SolutionState $state,
        private int           $labId,
        private UserModel     $user,
        private array         $files,
    )
    {
    }

    /**
     * @return int id решения
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string описание решения
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return SolutionState статус решения
     */
    public function getState(): SolutionState
    {
        return $this->state;
    }

    /**
     * @return int id лабы
     */
    public function getLabId(): int
    {
        return $this->labId;
    }

    /**
     * @return UserModel пользователь, загрузивший решение
     */
    public function getUser(): UserModel
    {
        return $this->user;
    }

    /**
     * @return FileModel[] дескрипторы связанных файлов
     */
    public function getFiles(): array
    {
        return $this->files;
    }
}