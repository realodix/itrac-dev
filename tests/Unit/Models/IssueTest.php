<?php

namespace Tests\Unit\Models;

use App\Enums\CommentType;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Tests\TestCase;

class IssueTest extends TestCase
{
    public Issue $issue;

    public function setUp(): void
    {
        parent::setUp();

        $this->issue = app(Issue::class);
    }

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
            ->has(Comment::factory([
                'type' => CommentType::Revision->value,
            ])->count(3))
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
            ->has(Comment::factory([
                'type' => CommentType::Revision->value,
            ])->count(3))
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
            ->has(Comment::factory([
                'type' => CommentType::Revision->value,
            ])->count(3))
            ->create();

        $this->assertEquals(3, $issue->participantCount());
    }

    /**
     * Test if the issue is closed or not.
     *
     * @test
     * @group u-model
     */
    public function isClosed()
    {
        $issue = Issue::factory([
                'closed_by' => $this->adminUser()->id
            ])->create();

        $this->assertTrue($issue->isClosed());

        $issue = Issue::factory([
                'closed_by' => null
            ])->create();

        $this->assertFalse($issue->isClosed());
    }

    /**
     * Test if the issue is locked or not.
     *
     * @test
     * @group u-model
     */
    public function isLocked()
    {
        $issue = Issue::factory([
                'locked_by' => $this->adminUser()->id
            ])->create();

        $this->assertTrue($issue->isLocked());

        $issue = Issue::factory([
                'locked_by' => null
            ])->create();

        $this->assertFalse($issue->isLocked());
    }
}
