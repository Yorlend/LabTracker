<?php

namespace App\Domain\Error;

use Exception;

/**
 * Ошибка "Не найдено"
 */
class NotFoundError extends Exception
{
    /**
     * @param string $msg подробное сообщение об ошибке
     */
    public function __construct(string $msg)
    {
        parent::__construct($msg);
    }
}