<?php

namespace App\Api\Auth;

use App\Domain\Service\UserService;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Сущность, которая дёргается при авторизации для получения пользователя
 *
 * @see UserProviderInterface
 */
readonly class UserProvider implements UserProviderInterface
{
    public function __construct(private UserService $service)
    {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        $login = (int)$user->getUserIdentifier();
        $user = $this->service->getByLogin($login);
        return new User($user->getId(), $user->getLogin(), $user->getPassword(), $user->getRole());
    }

    public function supportsClass(string $class): bool
    {
        return true;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->service->getByLogin($identifier);
        return new User($user->getId(), $user->getLogin(), $user->getPassword(), $user->getRole());
    }
}