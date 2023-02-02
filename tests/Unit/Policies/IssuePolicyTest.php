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
}
