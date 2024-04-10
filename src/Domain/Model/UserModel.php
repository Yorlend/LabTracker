<?php

namespace App\Domain\Model;

readonly class UserModel
{
    public function __construct(
        private int    $id,
        private string $userName,
        private string $login,
        private string $password,
        private Role   $role,
    ) {
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}