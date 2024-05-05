<?php

namespace App\Api\Auth;

use App\Domain\Model\Role;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Сущность содержащая креды текущего пользователя, которые были получены из jwt токена
 *
 * @see UserInterface
 * @see PasswordAuthenticatedUserInterface
 */
readonly class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private int    $id,
        private string $login,
        private string $password,
        private Role   $role
    )
    {
    }

    public function getRoles(): array
    {
        if ($this->role == Role::Administrator) {
            return ['ROLE_ADMIN'];
        } elseif ($this->role == Role::Teacher) {
            return ['ROLE_TEACHER'];
        } elseif ($this->role == Role::Student) {
            return ['ROLE_STUDENT'];
        }

        return ['ROLE_STUDENT'];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getId(): int
    {
        return $this->id;
    }
}