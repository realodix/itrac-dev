<?php

namespace App\Enums;

enum HistoryEvent: int
{
    case Created = 1;
    case Updated = 2;
}
