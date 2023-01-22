<?php

namespace Tests\Unit\Controllers;

use App\Models\Issue;
use App\Models\User;
use Tests\TestCase;

class IssueControllerTest extends TestCase
{
    /**
     * User can delete a issue.
     *
     * @test
     */
    public function user_can_delete_a_issue()
    {
        $issue = Issue::factory()
            ->for(User::factory()->create(), 'author')
            ->create();

        $this->actingAs($issue->author)
            ->get(route('issue.delete', $issue))
            ->assertRedirect(route('home'));
        $this->assertDatabaseMissing('issues', $issue->toArray());
    }
}
