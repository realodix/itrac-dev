<?php

namespace Tests\Unit\Policies;

use App\Models\Issue;
use App\Models\User;
use Tests\TestCase;

class IssuePolicyTest extends TestCase
{
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
        $user = User::factory()->create();
        $user->assignRole('admin');
        $issue = Issue::factory()->create();

        $this->assertTrue($user->can('forceDelete', $issue));

        $response = $this->actingAs($user)
            ->get(route('issue.delete', $issue));
        $response->assertStatus(302);
    }

    /**
     * Not author and not admin cannot delete the issue.
     * Not author is the user who did not create the issue.
     *
     * @test
     * @group u-policy
     */
    public function notAuthorCannotDeleteIssue()
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
