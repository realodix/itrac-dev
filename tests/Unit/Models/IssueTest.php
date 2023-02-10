<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Tests\TestCase;

class IssueTest extends TestCase
{
    /**
     * @test
     * @group u-model
     */
    public function hasManyComments()
    {
        $issue = Issue::factory()
            ->has(Comment::factory())
            ->create();

        $comment = $issue->comments->firstOrFail();

        $this->assertTrue($issue->comments()->exists());
        $this->assertEquals($issue->id, $comment->issue_id);
        $this->assertEquals(1, $issue->comments->count());
    }

    /**
     * @test
     * @group u-model
     */
    public function belongsToUser()
    {
        $issue = Issue::factory()
            ->for(User::factory()->create(), 'author')
            ->create();

        $this->assertTrue($issue->author()->exists());
        $this->assertEquals($issue->author_id, $issue->author->id);
        $this->assertEquals(1, $issue->author->count());
    }

    /**
     * Cooment count
     *
     * @test
     * @group u-model
     */
    public function commentCount()
    {
        $issue = Issue::factory()
            ->has(Comment::factory()->count(3))
            ->create();

        $this->assertEquals(3, $issue->commentCount());
    }

    /**
     * Get the participants of the issue.
     *
     * @test
     * @group u-model
     */
    public function participants()
    {
        $issue = Issue::factory()
            ->has(Comment::factory()->count(3))
            ->create();

        $this->assertEquals(3, $issue->participants()->count());
    }

    /**
     * Count the number of participants of the issue.
     *
     * @test
     * @group u-model
     */
    public function participantCount()
    {
        $issue = Issue::factory()
            ->has(Comment::factory()->count(3))
            ->create();

        $this->assertEquals(3, $issue->participantCount());
    }
}
