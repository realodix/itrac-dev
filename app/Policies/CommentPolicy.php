<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->author_id // Comment author
            || $user->id === $comment->issue->author_id // Issue author
            || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Comment $comment)
    {
        return $user->id === $comment->author_id // Comment author
            || $user->id === $comment->issue->author_id // Issue author
            || $user->hasRole('admin');
    }
}
