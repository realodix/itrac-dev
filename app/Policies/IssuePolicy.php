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
     */
    public function update(User $user, Issue $issue): bool
    {
        return $user->id === $issue->author_id
            || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Issue $issue): bool
    {
        return $user->id === $issue->author_id
            || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can close the issue.
     */
    public function close(User $user, Issue $issue): bool
    {
        return $user->id === $issue->author_id
            || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can reopen the issue.
     */
    public function reopen(User $user, Issue $issue): bool
    {
        return $user->id === $issue->author_id
            || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can lock the issue.
     */
    public function lock(User $user, Issue $issue): bool
    {
        return $user->id === $issue->author_id
            || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can unlock the issue.
     */
    public function unlock(User $user, Issue $issue): bool
    {
        return $user->id === $issue->author_id
            || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function createCommentLockedIssues(User $user, Issue $issue): bool
    {
        return $issue->isAuthor()
            || $issue->isParticipant()
            || $user->hasRole('admin');
    }
}
