<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Issue $issue)
    {
        return $user->id === $issue->author_id
            || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Issue $issue)
    {
        return $user->id === $issue->author_id
            || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can close the issue.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function close(User $user, Issue $issue): bool
    {
        return $user->id === $issue->author_id
            || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can reopen the issue.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reopen(User $user, Issue $issue): bool
    {
        return $user->id === $issue->author_id
            || $user->hasRole('admin');
    }
}
