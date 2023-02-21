<?php

namespace App\Enums;

enum HistoryEvent: int
{
    case CREATED = 1;
    case UPDATED = 2;
}
