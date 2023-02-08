<?php

namespace Tests\Unit\Policies;

use App\Models\Comment;
use App\Models\User;
use Tests\TestCase;

class CommentPolicyTest extends TestCase
{
    /**
     * Comment author can update the comment.
     * Comment author is the user who created the comment.
     *
     * @test
     * @group u-policy
     */
    public function authorCanUpdateComment()
    {
        $comment = Comment::factory()->create();

        $this->assertTrue($comment->author->can('update', $comment));

        $response = $this->actingAs($comment->author)
            ->get(route('comment.edit', $comment));
        $response->assertStatus(200);
    }

    /**
     * Issue author can update the comment.
     * Issue author is the user who created the issue.
     *
     * @test
     * @group u-policy
     */
    public function issueAuthorCanUpdateComment()
    {
        $comment = Comment::factory()->create();

        $this->assertTrue($comment->author->can('update', $comment));

        $response = $this->actingAs($comment->author)
            ->get(route('comment.edit', $comment));
        $response->assertStatus(200);
    }

    /**
     * Admin can update the comment.
     * Admin is the user who has the admin role.
     *
     * @test
     * @group u-policy
     */
    public function adminCanUpdateComment()
    {
        $comment = Comment::factory()->create();
        $adminUser = $this->adminUser();

        $this->assertTrue($adminUser->can('update', $comment));

        $response = $this->actingAs($adminUser)
            ->get(route('comment.edit', $comment));
        $response->assertStatus(200);
    }

    /**
     * Non-author and non-admin cannot update the comment.
     * Non-author is the user who did not create the comment.
     *
     * @test
     * @group u-policy
     */
    public function nonAuthorCannotUpdateComment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $this->assertFalse($user->can('update', $comment));

        $response = $this->actingAs($user)
            ->get(route('comment.edit', $comment));
        $response->assertForbidden();
    }

    /**
     * Guest cannot update the comment.
     *
     * @test
     * @group u-policy
     */
    public function guestCannotUpdateComment()
    {
        $comment = Comment::factory()->create();

        $response = $this->get(route('comment.edit', $comment));
        $response->assertForbidden();
    }

    /**
     * Comment author can delete the comment.
     * Comment author is the user who created the comment.
     *
     * @test
     * @group u-policy
     */
    public function authorCanDeleteComment()
    {
        $comment = Comment::factory()->create();

        $this->assertTrue($comment->author->can('forceDelete', $comment));

        $response = $this->actingAs($comment->author)
            ->get(route('comment.delete', $comment));
        $response->assertStatus(302);
    }

    /**
     * Issue author can delete the comment.
     * Issue author is the user who created the issue.
     *
     * @test
     * @group u-policy
     */
    public function issueAuthorCanDeleteComment()
    {
        $comment = Comment::factory()->create();

        $this->assertTrue($comment->author->can('forceDelete', $comment));

        $response = $this->actingAs($comment->author)
            ->get(route('comment.delete', $comment));
        $response->assertStatus(302);
    }

    /**
     * Admin can delete the comment.
     * Admin is the user who has the admin role.
     *
     * @test
     * @group u-policy
     */
    public function adminCanDeleteComment()
    {
        $comment = Comment::factory()->create();
        $adminUser = $this->adminUser();

        $this->assertTrue($adminUser->can('forceDelete', $comment));

        $response = $this->actingAs($adminUser)
            ->get(route('comment.delete', $comment));
        $response->assertStatus(302);
    }

    /**
     * Non-author and non-admin cannot delete the comment.
     * Non-author is the user who did not create the comment.
     *
     * @test
     * @group u-policy
     */
    public function nonAuthorCannotDeleteComment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $this->assertFalse($user->can('forceDelete', $comment));

        $response = $this->actingAs($user)
            ->get(route('comment.delete', $comment));
        $response->assertForbidden();
    }

    /**
     * Guest cannot delete the comment.
     * Guest is the user who is not logged in.
     *
     * @test
     * @group u-policy
     */
    public function guestCannotDeleteComment()
    {
        $comment = Comment::factory()->create();

        $response = $this->get(route('comment.delete', $comment));
        $response->assertForbidden();
    }
}
