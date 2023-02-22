<?php

namespace App\Enums;

enum HistoryTag: string
{
    case IssueStatus = 'status';
    case IssueTitle = 'title';
    case Comment = 'comment';
    case CommentStatus = 'comment_status';
}
