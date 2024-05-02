<?php

namespace App\Api\Request\Group;

use App\Api\Request\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints as Assert;

class UsersIdRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank(message: 'users_id must be not empty')]
    #[Assert\Type(type: 'array', message: "users_id must be array")]
    public readonly array $usersId;
}