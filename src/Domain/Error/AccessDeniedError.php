<?php

namespace App\Domain\Error;

use Exception;

/**
 * Ошибка "Нет доступа"
 */
class AccessDeniedError extends Exception
{
    /**
     * @param string $msg подробное сообщение об ошибке
     */
    public function __construct(string $msg = "Access Denied")
    {
        parent::__construct($msg);
    }
}