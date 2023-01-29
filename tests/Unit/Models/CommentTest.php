<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Issue;
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

        /** @var \App\Models\User */
        $author = $c->author()->first();

        $this->assertTrue($c->author()->exists());
        $this->assertEquals($c->author_id, $author->id);
        $this->assertEquals(1, $c->author()->count());
    }

    /**
     * @test
     * @group u-model
     */
    public function belongsToIssue()
    {
        $c = Comment::factory()
            ->for(Issue::factory()->create())
            ->create();

        /** @var \App\Models\User */
        $author = $c->author()->first();

        $this->assertTrue($c->author()->exists());
        $this->assertEquals($c->author_id, $author->id);
        $this->assertEquals(1, $c->author()->count());
    }
}
