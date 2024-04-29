<?php

namespace App\Api\Request\Group;

use App\Api\Request\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints as Assert;

class StoreRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank(message: 'name must be not empty')]
    #[Assert\Type(type: 'string', message: "name must be string")]
    public readonly string $name;

    #[Assert\NotBlank(message: 'teacher_id must be not empty')]
    #[Assert\Type(type: 'integer', message: "teacher_id must be integer")]
    public readonly int $teacherId;

    #[Assert\NotBlank(message: 'users_id must be not empty')]
    #[Assert\Type(type: 'array', message: "users_id must be array")]
    public readonly array $usersId;
}