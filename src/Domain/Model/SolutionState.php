<?php

namespace App\Domain\Model;

/**
 * Сущность состояния решения
 */
enum SolutionState : int
{
    case Issued = 1;
    case Checking = 2;
    case Revision = 3;
    case Done = 4;
    case Rejected = 5;
}
