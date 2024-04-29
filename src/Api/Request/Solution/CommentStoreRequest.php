<?php

namespace App\Api\Request\Solution;

use App\Api\Request\AbstractJsonRequest;
use Symfony\Component\Validator\Constraints as Assert;

class CommentStoreRequest extends AbstractJsonRequest
{
    #[Assert\NotBlank(message: 'text must be not empty')]
    #[Assert\Type(type: 'string', message: "text must be string")]
    public readonly string $text;
}