<?php

namespace App\Domain\Model;

/**
 * Сущность пользователя
 */
readonly class UserModel
{
    /**
     * @param int $id id пользователя
     * @param string $userName имя пользователя
     * @param string $login логин
     * @param string $password пароль
     * @param Role $role роль пользователя
     */
    public function __construct(
        private int    $id,
        private string $userName,
        private string $login,
        private string $password,
        private Role   $role,
    )
    {
    }

    /**
     * @return int id пользователя
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string имя пользователя
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string логин
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string пароль
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return Role роль пользователя
     */
    public function getRole(): Role
    {
        return $this->role;
    }
}