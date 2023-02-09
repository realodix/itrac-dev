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
        // $user = User::factory()->create();
        // $issue = $user->issues()->create([
        //     'author_id'   => $user->id,
        //     'title'       => 'test issue',
        //     'description' => 'test issue description',
        // ]);
        $comment = Comment::factory()->create([
            // 'author_id'   => $user->id,
            'description' => 'test comment',
        ]);

        $this->actingAs($comment->author)
            ->post(route('comment.store', $comment->issue->id), ['comment_summary' => 'test comment'])
            ->assertRedirect(route('issue.show.comment', [
                $comment->issue->id,
                $comment->id + 1, // +1 because the comment is created before the test
            ]));
        $this->assertDatabaseHas('comments', [
            // 'author_id' => $user->id,
            'issue_id' => $comment->issue->id,
            'description' => 'test comment',
        ]);
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
            ->post(route('comment.update', $comment), ['comment_summary' => 'new text'])
            ->assertRedirect(route('issue.show.comment', [$comment->issue->id, $comment->id]));
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
