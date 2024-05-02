<?php

namespace App\Api\Request\Solution;

use App\Api\Request\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints as Assert;

class StoreRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank(message: 'description must be not empty')]
    #[Assert\Type(type: 'string', message: "description must be string")]
    public readonly string $description;

    #[Assert\NotBlank(message: 'lab_id must be not empty')]
    #[Assert\Type(type: 'integer', message: "lab_id must be integer")]
    public readonly int $labId;
}