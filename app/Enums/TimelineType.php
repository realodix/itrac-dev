<?php

namespace App\Enums;

enum TimelineType: int
{
    case Comment = 1;
    case StatusUpdate = 2;
}
