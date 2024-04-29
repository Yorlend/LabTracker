<?php

namespace App\Api\Request\Lab;

use App\Api\Request\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints as Assert;

class StoreRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank(message: 'name must be not empty')]
    #[Assert\Type(type: 'string', message: "name must be string")]
    public readonly string $name;

    #[Assert\NotBlank(message: 'description must be not empty')]
    #[Assert\Type(type: 'string', message: "description must be string")]
    public readonly string $description;

    #[Assert\NotBlank(message: 'group_id must be not empty')]
    #[Assert\Type(type: 'integer', message: "group_id must be integer")]
    public readonly int $groupId;
}