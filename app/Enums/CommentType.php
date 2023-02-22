<?php

namespace App\Enums;

enum CommentType: string
{
    case Comment = 'comment';
    case Revision = 'revision';
}
