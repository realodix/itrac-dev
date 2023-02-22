<?php

namespace App\Enums;

enum HistoryTag: string
{
    case IssueTitle    = 'title';
    case IssueStatus   = 'status';
    case CommentStatus = 'comment_status';
    case Comment = 'comment';
    case Close   = 'close';
    case Open    = 'open';
    case Lock    = 'lock';
    case Unlock  = 'unlock';
}
