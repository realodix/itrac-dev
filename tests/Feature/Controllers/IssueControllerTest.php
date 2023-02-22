<?php

namespace Tests\Feature\Controllers;

use App\Models\Issue;
use App\Models\User;
use Tests\TestCase;

class IssueControllerTest extends TestCase
{
    /**
     * User can see the issue index page.
     *
     * @test
     */
    public function user_can_see_the_issue_index_page()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('home'))
            ->assertOk()
            ->assertViewIs('sections.issue.index');
    }

    /**
     * User can see the create issue page.
     *
     * @test
     */
    public function user_can_see_the_create_issue_page()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('issue.create'))
            ->assertOk()
            ->assertViewIs('sections.issue.create');
    }

    /**
     * User can create a issue.
     *
     * @test
     */
    public function user_can_create_an_issue()
    {
        $response = $this->actingAs($this->adminUser())
            ->post(route('issue.store'), [
                'issue_title'       => 'foo',
                'issue_description' => 'bar',
            ]);
        $i = Issue::where('title', 'foo')->latest()->firstOrFail();
        $response->assertRedirectToRoute('issue.show', $i->id);
    }

    /**
     * User can create a issue with blank title.
     *
     * @test
     */
    public function user_can_create_an_issue_with_blank_title()
    {
        $response = $this->actingAs($this->adminUser())
            ->post(route('issue.store'), [
                'issue_description' => 'foo',
            ]);
        $i = Issue::where('description', 'foo')->latest()->firstOrFail();
        $response->assertRedirectToRoute('issue.show', $i->id);
        $this->assertSame('No title', $i->title);
    }

    /**
     * User can see the issue show page.
     *
     * @test
     */
    public function user_can_see_the_issue_show_page()
    {
        $issue = Issue::factory()->create();

        $this->actingAs($issue->author)
            ->get(route('issue.show', $issue))
            ->assertOk()
            ->assertViewIs('sections.issue.show');
    }

    /**
     * User can see the issue edit page.
     *
     * @test
     */
    public function user_can_see_the_issue_edit_page()
    {
        $issue = Issue::factory()->create();

        $this->actingAs($issue->author)
            ->get(route('issue.edit', $issue))
            ->assertOk()
            ->assertViewIs('sections.issue.edit');
    }

    /**
     * User can update a issue.
     *
     * @test
     */
    public function user_can_update_an_issue()
    {
        $issue = Issue::factory()->create();

        $this->actingAs($issue->author)
            ->post(route('issue.update', $issue), [
                'title'       => 'new title',
                'description' => 'new description',
            ])
            ->assertRedirect(route('issue.show', $issue));

        $this->assertDatabaseHas('issues', [
            'id'          => $issue->id,
            'title'       => 'new title',
            'description' => 'new description',
        ]);
    }

    /**
     * User can delete a issue.
     *
     * @test
     */
    public function user_can_delete_an_issue()
    {
        $issue = Issue::factory()->create();

        $this->actingAs($issue->author)
            ->get(route('issue.delete', $issue))
            ->assertRedirect(route('home'));
        $this->assertDatabaseMissing('issues', $issue->toArray());
    }

    /**
     * User can close a issue.
     *
     * @test
     */
    public function user_can_close_an_issue()
    {
        $issue = Issue::factory()->create();

        $this->actingAs($issue->author)
            ->get(route('issue.close', $issue))
            ->assertRedirect(route('issue.show', $issue));
        $this->assertDatabaseHas('issues', [
            'id'        => $issue->id,
            'is_closed' => true,
        ]);
    }

    /**
     * User can reopen a issue.
     *
     * @test
     */
    public function user_can_reopen_an_issue()
    {
        $issue = Issue::factory()->create();

        $this->actingAs($issue->author)
            ->get(route('issue.reopen', $issue))
            ->assertRedirect(route('issue.show', $issue));
        $this->assertDatabaseHas('issues', [
            'id'        => $issue->id,
            'is_closed' => false,
        ]);
    }
}
