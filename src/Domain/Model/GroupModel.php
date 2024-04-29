<?php

namespace App\Domain\Model;

/**
 * Сущность группы
 */
readonly class GroupModel
{
    /**
     * @param int $id Id группы
     * @param string $name Имя группы
     * @param int[] $usersIds Id студентов в группе
     * @param int $teacherId Id преподавателя
     */
    public function __construct(
        private int    $id,
        private string $name,
        private array  $usersIds,
        private int    $teacherId,
    )
    {
    }

    /**
     * @return int Id группы
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string Имя группы
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int[] Id студентов в группе
     */
    public function getUsersIds(): array
    {
        return $this->usersIds;
    }

    /**
     * @return int Id преподавателя
     */
    public function getTeacher(): int
    {
        return $this->teacherId;
    }

}