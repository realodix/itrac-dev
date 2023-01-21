<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     * @group u-model
     */
    public function hasManyIsuues()
    {
        $user = User::factory()
            ->has(Issue::factory())
            ->create();

        $this->assertTrue($user->issues()->exists());
        $this->assertEquals($user->id, $user->issues()->first()->author_id);
        $this->assertEquals(1, $user->issues()->count());
    }

    /**
     * @test
     * @group u-model
     */
    public function hasManyComments()
    {
        $user = User::factory()
            ->has(Comment::factory())
            ->create();

        $this->assertTrue($user->comments()->exists());
        $this->assertEquals($user->id, $user->comments()->first()->author_id);
        $this->assertEquals(1, $user->comments()->count());
    }
}
