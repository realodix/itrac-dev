<?php

namespace App\Enums;

enum HistoryTag: string
{
    case IssueStatus = 'status';
    case IssueTitle = 'title';
    case Comment = 'comment';
    case CommentStatus = 'comment_status';

    case Close = 'close';
    case Open = 'open';
    case Lock = 'lock';
    case Unlock = 'unlock';
}
