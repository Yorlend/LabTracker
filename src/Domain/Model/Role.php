<?php

namespace App\Domain\Model;

enum Role
{
    case Administrator;
    case Teacher;
    case Student;
}
