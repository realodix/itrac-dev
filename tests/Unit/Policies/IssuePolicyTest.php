<?php

namespace Tests\Unit\Policies;

use App\Models\Issue;
use App\Models\User;
use Tests\TestCase;

class IssuePolicyTest extends TestCase
{
    /**
     * Issue author can update the issue.
     * Author is the user who created the issue.
     *
     * @test
     * @group u-policy
     */
    public function authorCanUpdateIssue()
    {
        $issue = Issue::factory()->create();

        $this->assertTrue($issue->author->can('update', $issue));

        $response = $this->actingAs($issue->author)
            ->get(route('issue.edit', $issue));
        $response->assertOk();
    }

    /**
     * Admin can update the issue.
     * Admin is the user who has the admin role.
     *
     * @test
     * @group u-policy
     */
    public function adminCanUpdateIssue()
    {
        $issue = Issue::factory()->create();
        $adminUser = $this->adminUser();

        $this->assertTrue($adminUser->can('update', $issue));

        $response = $this->actingAs($adminUser)
            ->get(route('issue.edit', $issue));
        $response->assertOk();
    }

    /**
     * Non issue author cannot update the issue.
     *
     * @test
     * @group u-policy
     */
    public function nonAuthorCannotUpdateIssue()
    {
        $issue = Issue::factory()->create();
        $nonAuthor = User::factory()->create();

        $this->assertFalse($nonAuthor->can('update', $issue));

        $response = $this->actingAs($nonAuthor)
            ->get(route('issue.edit', $issue));
        $response->assertForbidden();
    }

    /**
     * Guest cannot update the issue.
     *
     * @test
     * @group u-policy
     */
    public function guestCannotUpdateIssue()
    {
        $issue = Issue::factory()->create();

        $response = $this->get(route('issue.edit', $issue));
        $response->assertForbidden();
    }

    /**
     * Issue author can delete the issue.
     * Author is the user who created the issue.
     *
     * @test
     * @group u-policy
     */
    public function authorCanDeleteIssue()
    {
        $issue = Issue::factory()->create();

        $this->assertTrue($issue->author->can('forceDelete', $issue));

        $response = $this->actingAs($issue->author)
            ->get(route('issue.delete', $issue));
        $response->assertStatus(302);
    }

    /**
     * Admin can delete the issue.
     * Admin is the user who has the admin role.
     *
     * @test
     * @group u-policy
     */
    public function adminCanDeleteIssue()
    {
        $issue = Issue::factory()->create();
        $adminUser = $this->adminUser();

        $this->assertTrue($adminUser->can('forceDelete', $issue));

        $response = $this->actingAs($adminUser)
            ->get(route('issue.delete', $issue));
        $response->assertStatus(302);
    }

    /**
     * Non-author and non-admin cannot delete the issue.
     * Non-author is the user who did not create the issue.
     *
     * @test
     * @group u-policy
     */
    public function nonAuthorCannotDeleteIssue()
    {
        $user = User::factory()->create();
        $issue = Issue::factory()->create();

        $this->assertFalse($user->can('forceDelete', $issue));

        $response = $this->actingAs($user)
            ->get(route('issue.delete', $issue));
        $response->assertForbidden();
    }

    /**
     * Guest cannot delete the issue.
     * Guest is the user who is not logged in.
     *
     * @test
     * @group u-policy
     */
    public function guestCannotDeleteIssue()
    {
        $issue = Issue::factory()->create();

        $response = $this->get(route('issue.delete', $issue));
        $response->assertForbidden();
    }

    /**
     * Issue author can close the issue.
     * Author is the user who created the issue.
     *
     * @test
     * @group u-policy
     */
    public function authorCanCloseIssue()
    {
        $issue = Issue::factory()->create();

        $this->assertTrue($issue->author->can('close', $issue));

        $response = $this->actingAs($issue->author)
            ->get(route('issue.close', $issue));
        $response->assertStatus(302);
    }

    /**
     * Admin can close the issue.
     * Admin is the user who has the admin role.
     *
     * @test
     * @group u-policy
     */
    public function adminCanCloseIssue()
    {
        $issue = Issue::factory()->create();
        $adminUser = $this->adminUser();

        $this->assertTrue($adminUser->can('close', $issue));

        $response = $this->actingAs($adminUser)
            ->get(route('issue.close', $issue));
        $response->assertStatus(302);
    }

    /**
     * Non-author and non-admin cannot close the issue.
     * Non-author is the user who did not create the issue.
     *
     * @test
     * @group u-policy
     */
    public function nonAuthorCannotCloseIssue()
    {
        $user = User::factory()->create();
        $issue = Issue::factory()->create();

        $this->assertFalse($user->can('close', $issue));

        $response = $this->actingAs($user)
            ->get(route('issue.close', $issue));
        $response->assertForbidden();
    }

    /**
     * Guest cannot close the issue.
     * Guest is the user who is not logged in.
     *
     * @test
     * @group u-policy
     */
    public function guestCannotCloseIssue()
    {
        $issue = Issue::factory()->create();

        $response = $this->get(route('issue.close', $issue));
        $response->assertForbidden();
    }

    /**
     * Issue author can reopen the issue.
     * Author is the user who created the issue.
     *
     * @test
     * @group u-policy
     */
    public function authorCanReopenIssue()
    {
        $issue = Issue::factory()->create();

        $this->assertTrue($issue->author->can('reopen', $issue));

        $response = $this->actingAs($issue->author)
            ->get(route('issue.reopen', $issue));
        $response->assertStatus(302);
    }

    /**
     * Admin can reopen the issue.
     * Admin is the user who has the admin role.
     *
     * @test
     * @group u-policy
     */
    public function adminCanReopenIssue()
    {
        $issue = Issue::factory()->create();
        $adminUser = $this->adminUser();

        $this->assertTrue($adminUser->can('reopen', $issue));

        $response = $this->actingAs($adminUser)
            ->get(route('issue.reopen', $issue));
        $response->assertStatus(302);
    }

    /**
     * Non-author and non-admin cannot reopen the issue.
     * Non-author is the user who did not create the issue.
     *
     * @test
     * @group u-policy
     */
    public function nonAuthorCannotReopenIssue()
    {
        $user = User::factory()->create();
        $issue = Issue::factory()->create();

        $this->assertFalse($user->can('reopen', $issue));

        $response = $this->actingAs($user)
            ->get(route('issue.reopen', $issue));
        $response->assertForbidden();
    }

    /**
     * Guest cannot reopen the issue.
     * Guest is the user who is not logged in.
     *
     * @test
     * @group u-policy
     */
    public function guestCannotReopenIssue()
    {
        $issue = Issue::factory()->create();

        $response = $this->get(route('issue.reopen', $issue));
        $response->assertForbidden();
    }

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
}
