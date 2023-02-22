<?php

namespace App\Enums;

enum EventType: int
{
    case Closed = 1;
    case Reopened = 2;
    case Locked = 3;
    case Unlocked = 4;
}
