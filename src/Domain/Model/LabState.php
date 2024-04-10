<?php

namespace App\Domain\Model;

enum LabState
{
    case Issued;
    case Checking;
    case Revision;
    case Done;
    case Rejected;
}
