<?php

namespace App\Api\Request\Solution;
use App\Api\Request\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank(message: 'description must be not empty')]
    #[Assert\Type(type: 'string', message: "description must be string")]
    public readonly string $description;

    #[Assert\NotBlank(message: 'state must be not empty')]
    #[Assert\Type(type: 'integer', message: "state must be integer")]
    public readonly int $state;
}