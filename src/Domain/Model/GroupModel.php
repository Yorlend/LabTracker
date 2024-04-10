<?php

namespace App\Domain\Model;

readonly class GroupModel
{
    /**
     * @param int $id
     * @param UserModel[] $users Студенты в группе
     * @param UserModel $teacher Ответственный преподаватель
     */
    public function __construct(
        private int $id,
        private array $users,
        private UserModel $teacher,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsers(): array
    {
        return $this->users;
    }

    public function getTeacher(): UserModel
    {
        return $this->teacher;
    }


}