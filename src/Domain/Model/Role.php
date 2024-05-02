<?php

namespace App\Domain\Model;

/**
 * Сущность роли пользователя
 */
enum Role : int
{
    case Administrator = 1;
    case Teacher = 2;
    case Student = 3;
}
