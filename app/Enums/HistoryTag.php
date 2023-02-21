<?php

namespace App\Enums;

enum HistoryTag: int
{
    case CLOSED = 1;
    case REOPENED = 2;
    case LOCKED = 3;
    case UNLOCKED = 4;
}
