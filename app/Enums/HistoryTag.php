<?php

namespace App\Enums;

enum HistoryTag: string
{
    case ISSUE_STATUS = 'status';
    case ISSUE_TITLE = 'title';
    case COMMENT = 'comment';
    case COMMENT_STATUS = 'comment_status';
}
