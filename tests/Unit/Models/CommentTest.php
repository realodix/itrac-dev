<?php

namespace Tests\Unit\Models;

use App\Enums\CommentType;
use App\Models\Comment;
use App\Models\User;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * @test
     * @group u-model
     */
    public function belongsToUser()
    {
        $c = Comment::factory()
            ->for(User::factory(), 'author')
            ->create();

        $this->assertTrue($c->author()->exists());
        $this->assertEquals($c->author_id, $c->author->id);
        $this->assertEquals(1, $c->author()->count());
    }

    /**
     * @test
     * @group u-model
     */
    public function belongsToIssue()
    {
        $c = Comment::factory()->create();

        $this->assertTrue($c->author()->exists());
        $this->assertEquals($c->author_id, $c->author->id);
        $this->assertEquals(1, $c->author()->count());
    }

    /**
     * Determine if the comment was written by the current authenticated user.
     *
     * @test
     * @group u-model
     */
    public function isAuthor()
    {
        $c = Comment::factory()->create();
        $this->assertFalse($c->isAuthor());

        $this->actingAs($c->author);
        $this->assertTrue($c->isAuthor());
    }

    /**
     * Determine if the comment was written by the issue author.
     *
     * @test
     * @group u-model
     */
    public function isIssueAuthor()
    {
        $c = Comment::factory()->create();
        $this->assertFalse($c->isIssueAuthor());

        $c->issue->author()->associate($c->author);
        $c->issue->save();
        $this->assertTrue($c->isIssueAuthor());
    }

    /**
     * Determine if the type of the comment is a comment.
     *
     * @test
     * @group u-model
     */
    public function isComment()
    {
        $c = Comment::factory()->create();
        $this->assertTrue($c->isComment());

        $c = Comment::factory()->create([
            'type' => CommentType::Revision->value,
        ]);
        $this->assertFalse($c->isComment());
    }
}
