<?php

namespace App\Api\Request\User;

use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateRequest
{
    #[Assert\NotBlank(message: 'password must be not empty')]
    #[Assert\Type(type: 'string', message: "password must be string")]
    public readonly string $password;

    #[Assert\NotBlank(message: 'user_name must be not empty')]
    #[Assert\Type(type: 'string', message: "user_name must be string")]
    public readonly string $userName;

    #[Assert\NotBlank(message: 'role must be not empty')]
    #[Assert\Range(
        notInRangeMessage: 'Expected to be between {{ min }} and {{ max }}, got {{ value }}',
        min: 1,
        max: 3,
    )]
    public readonly int $role;

    public function toEntity(): UserModel
    {
        return new UserModel(0, $this->userName, "", $this->password, Role::from($this->role));
    }
}