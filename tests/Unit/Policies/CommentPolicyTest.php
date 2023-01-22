<?php

namespace Tests\Unit\Policies;

use App\Models\Issue;
use App\Models\User;
use App\Models\Comment;
use Tests\TestCase;

class CommentPolicyTest extends TestCase
{
    /**
     * Comment author can delete the comment.
     * Comment author is the user who created the comment.
     *
     * @test
     * @group u-policy
     */
    public function authorCanDeleteComment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['author_id' => $user->id]);

        $this->assertTrue($user->can('forceDelete', $comment));
    }

    /**
     * Issue author can delete the comment.
     * Issue author is the user who created the issue.
     *
     * @test
     * @group u-policy
     */
    public function issueAuthorCanDeleteComment()
    {
        $user = User::factory()->create();
        $issue = Issue::factory()->create(['author_id' => $user->id]);
        $comment = Comment::factory()->create(['issue_id' => $issue->id]);

        $this->assertTrue($user->can('forceDelete', $comment));
    }

    /**
     * Admin can delete the comment.
     * Admin is the user who has the admin role.
     *
     * @test
     * @group u-policy
     */
    public function adminCanDeleteComment()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $comment = Comment::factory()->create();

        $this->assertTrue($user->can('forceDelete', $comment));
    }

    /**
     * Not author and not admin cannot delete the comment.
     * Not author is the user who did not create the comment.
     *
     * @test
     * @group u-policy
     */
    public function notAuthorCannotDeleteComment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $this->assertFalse($user->can('forceDelete', $comment));
    }
}
