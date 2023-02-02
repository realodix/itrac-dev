<?php

namespace Tests\Unit\Controllers;

use App\Models\Comment;
use App\Models\User;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    /**
     * User can create a comment.
     *
     * @test
     */
    public function user_can_create_a_comment()
    {
        $user = User::factory()->create();
        $issue = $user->issues()->create([
            'author_id'   => $user->id,
            'title'       => 'test issue',
            'description' => 'test issue description',
        ]);

        $this->actingAs($user)
            ->post(route('comment.store', $issue), ['comment_description' => 'test comment'])
            ->assertRedirect(route('issue.show', $issue->id));
        $this->assertDatabaseHas('comments', ['author_id' => $user->id, 'issue_id' => $issue->id, 'description' => 'test comment']);
    }

    /**
     * User can edit a comment.
     *
     * @test
     */
    public function user_can_edit_a_comment()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->author)
            ->get(route('comment.edit', $comment))
            ->assertViewIs('sections.comment.edit')
            ->assertViewHas('comment', $comment);
    }

    /**
     * User can update a comment.
     *
     * @test
     */
    public function user_can_update_a_comment()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->author)
            ->post(route('comment.update', $comment), ['comment_description' => 'new text'])
            ->assertRedirect(route('issue.show', $comment->issue));
        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'description' => 'new text']);
    }

    /**
     * User can delete a comment.
     *
     * @test
     */
    public function user_can_delete_a_comment()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->author)
            ->get(route('comment.delete', $comment))
            ->assertRedirect(route('issue.show', $comment->issue->id));
        $this->assertDatabaseMissing('comments', $comment->toArray());
    }
}
