<?php

namespace App\Enums;

enum EventType: int
{
    case CLOSED = 1;
    case REOPENED = 2;
    case LOCKED = 3;
    case UNLOCKED = 4;

}
