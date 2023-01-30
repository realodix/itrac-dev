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

        /** @var \App\Models\Comment */
        $comment = $issue->comments->first();

        $this->assertTrue($issue->comments()->exists());
        $this->assertEquals($issue->id, $comment->issue_id);
        $this->assertEquals(1, $issue->comments()->count());
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
        $this->assertEquals(1, $issue->author()->count());
    }
}
