<?php

namespace App\Enums;

enum HistoryTag: string
{
    case Close = 'close';
    case Open = 'open';
    case Lock = 'lock';
    case Unlock = 'unlock';
}
