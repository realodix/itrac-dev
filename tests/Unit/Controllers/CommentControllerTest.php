<?php

namespace Tests\Unit\Controllers;

use App\Models\Comment;
use App\Models\User;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    /**
     * User can delete a comment.
     *
     * @test
     */
    public function user_can_delete_a_comment()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->author)
            ->get(route('issue.comment.delete', $comment))
            ->assertRedirect(route('issue.show', $comment->issue->id));
        $this->assertDatabaseMissing('comments', $comment->toArray());
    }
}
