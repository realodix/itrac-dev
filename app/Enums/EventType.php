<?php

namespace App\Enums;

enum EventType: int
{
    case OPEN = 1;
    case CLOSE = 2;
    case LOCK = 3;
    case UNLOCK = 4;

}
