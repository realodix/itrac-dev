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
            ->for(User::factory()->create(), 'author')
            ->create();

        $this->assertTrue($c->author()->exists());
        $this->assertEquals($c->author_id, $c->author()->first()->id);
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

        $this->assertTrue($c->author()->exists());
        $this->assertEquals($c->author_id, $c->author()->first()->id);
        $this->assertEquals(1, $c->author()->count());
    }
}
