<?php

namespace App\Domain\Error;

use Exception;

/**
 * Ошибка "Некорректный запрос"
 */
class BadRequestError extends Exception
{
    /**
     * @param string $msg подробное сообщение об ошибке
     */
    public function __construct(string $msg = "Bad request")
    {
        parent::__construct($msg);
    }
}