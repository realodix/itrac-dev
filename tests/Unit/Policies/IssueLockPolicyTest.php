<?php

namespace Tests\Unit\Policies;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Tests\TestCase;

class IssueLockPolicyTest extends TestCase
{
    /**
     * Issue author can lock the issue.
     * Author is the user who created the issue.
     *
     * @test
     * @group u-policy
     */
    public function authorCanLockIssue()
    {
        $issue = Issue::factory()->create();

        $this->assertTrue($issue->author->can('lock', $issue));

        $response = $this->actingAs($issue->author)
            ->get(route('issue.lock', $issue));
        $response->assertStatus(302);
    }

    /**
     * Admin can lock the issue.
     * Admin is the user who has the admin role.
     *
     * @test
     * @group u-policy
     */
    public function adminCanLockIssue()
    {
        $issue = Issue::factory()->create();
        $adminUser = $this->adminUser();

        $this->assertTrue($adminUser->can('lock', $issue));

        $response = $this->actingAs($adminUser)
            ->get(route('issue.lock', $issue));
        $response->assertStatus(302);
    }

    /**
     * Non-author and non-admin cannot lock the issue.
     * Non-author is the user who did not create the issue.
     *
     * @test
     * @group u-policy
     */
    public function nonAuthorCannotLockIssue()
    {
        $user = User::factory()->create();
        $issue = Issue::factory()->create();

        $this->assertFalse($user->can('lock', $issue));

        $response = $this->actingAs($user)
            ->get(route('issue.lock', $issue));
        $response->assertForbidden();
    }

    /**
     * Guest cannot lock the issue.
     * Guest is the user who is not logged in.
     *
     * @test
     * @group u-policy
     */
    public function guestCannotLockIssue()
    {
        $issue = Issue::factory()->create();

        $response = $this->get(route('issue.lock', $issue));
        $response->assertForbidden();
    }

    /**
     * Issue author can unlock the issue.
     * Author is the user who created the issue.
     *
     * @test
     * @group u-policy
     */
    public function authorCanUnlockIssue()
    {
        $issue = Issue::factory()->create();

        $this->assertTrue($issue->author->can('unlock', $issue));

        $response = $this->actingAs($issue->author)
            ->get(route('issue.unlock', $issue));
        $response->assertStatus(302);
    }

    /**
     * Admin can unlock the issue.
     * Admin is the user who has the admin role.
     *
     * @test
     * @group u-policy
     */
    public function adminCanUnlockIssue()
    {
        $issue = Issue::factory()->create();
        $adminUser = $this->adminUser();

        $this->assertTrue($adminUser->can('unlock', $issue));

        $response = $this->actingAs($adminUser)
            ->get(route('issue.unlock', $issue));
        $response->assertStatus(302);
    }

    /**
     * Non-author and non-admin cannot unlock the issue.
     * Non-author is the user who did not create the issue.
     *
     * @test
     * @group u-policy
     */
    public function nonAuthorCannotUnlockIssue()
    {
        $user = User::factory()->create();
        $issue = Issue::factory()->create();

        $this->assertFalse($user->can('unlock', $issue));

        $response = $this->actingAs($user)
            ->get(route('issue.unlock', $issue));
        $response->assertForbidden();
    }

    /**
     * Guest cannot unlock the issue.
     * Guest is the user who is not logged in.
     *
     * @test
     * @group u-policy
     */
    public function guestCannotUnlockIssue()
    {
        $issue = Issue::factory()->create();

        $response = $this->get(route('issue.unlock', $issue));
        $response->assertForbidden();
    }

    /**
     * Issue author can create the comment when the issue is locked.
     * Issue author is the user who created the issue.
     *
     * @test
     * @group u-policy
     */
    public function issueAuthorCanCreateCommentWhenIssueIsLocked()
    {
        $issue = Issue::factory()->create([
            'locked_by' => $this->adminUser()->id,
            'locked_at' => now(),
        ]);

        $response = $this->actingAs($issue->author)
            ->post(route('comment.store', $issue), [
                'comment_summary' => 'Test comment',
            ]);
        $response->assertStatus(302);
    }

    /**
     * Admin can create the comment when the issue is locked.
     * Admin is the user who has the admin role.
     *
     * @test
     * @group u-policy
     */
    public function adminCanCreateCommentWhenIssueIsLocked()
    {
        $user = User::factory()->create();
        $issue = Issue::factory()->create([
            'locked_by' => $user->id,
            'locked_at' => now(),
        ]);

        $response = $this->actingAs($this->adminUser())
            ->post(route('comment.store', $issue), [
                'comment_summary' => 'Test comment',
            ]);
        $response->assertStatus(302);
    }

    /**
     * User participant can create the comment when the issue is locked.
     *
     * Participant
     * - user who has commented on the issue before
     * - user who is the issue assignee
     *
     * @test
     * @group u-policy
     */
    public function userParticipantCanCreateCommentWhenIssueIsLocked()
    {
        $issue = Issue::factory()->create([
            'locked_by' => $this->adminUser()->id,
            'locked_at' => now(),
        ]);
        $comment = Comment::factory()->create([
            'issue_id' => $issue->id,
        ]);

        $response = $this->actingAs($comment->author)
            ->post(route('comment.store', $issue), [
                'comment_summary' => 'Test comment',
            ]);
        $response->assertStatus(302);
    }

    /**
     * Non-author and non-participant cannot create the comment when the issue is locked.
     * - Non-author is the user who did not create the issue.
     * - Non-participant
     *   - is the user who is not the issue author
     *   - not the issue assignee
     *   - user who has not commented on the issue before
     *
     * @test
     * @group u-policy
     */
    public function nonAuthorAndNonParticipantCannotCreateCommentWhenIssueIsLocked()
    {
        $user = User::factory()->create();
        $issue = Issue::factory()->create([
            'locked_by' => $user->id,
            'locked_at' => now(),
        ]);

        $response = $this->actingAs(User::factory()->create())
            ->post(route('comment.store', $issue), [
                'comment_summary' => 'Test comment',
            ]);
        $response->assertForbidden();
    }
}
