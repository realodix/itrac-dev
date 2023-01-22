<?php

namespace Tests\Unit\Policies;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Tests\TestCase;

class CommentPolicyTest extends TestCase
{
    /**
     * Comment author can delete the comment.
     * Comment author is the user who created the comment.
     *
     * @test
     * @group u-policy
     */
    public function authorCanDeleteComment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['author_id' => $user->id]);

        $this->assertTrue($user->can('forceDelete', $comment));

        $response = $this->actingAs($user)
            ->get(route('issue.comment.delete', $comment));
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
        $user = User::factory()->create();
        $issue = Issue::factory()->create(['author_id' => $user->id]);
        $comment = Comment::factory()->create(['issue_id' => $issue->id]);

        $this->assertTrue($user->can('forceDelete', $comment));

        $response = $this->actingAs($user)
            ->get(route('issue.comment.delete', $comment));
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
        $user = User::factory()->create();
        $user->assignRole('admin');
        $comment = Comment::factory()->create();

        $this->assertTrue($user->can('forceDelete', $comment));

        $response = $this->actingAs($user)
            ->get(route('issue.comment.delete', $comment));
        $response->assertStatus(302);
    }

    /**
     * Not author and not admin cannot delete the comment.
     * Not author is the user who did not create the comment.
     *
     * @test
     * @group u-policy
     */
    public function notAuthorCannotDeleteComment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $this->assertFalse($user->can('forceDelete', $comment));

        $response = $this->actingAs($user)
            ->get(route('issue.comment.delete', $comment));
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

         $response = $this->get(route('issue.comment.delete', $comment));
         $response->assertForbidden();
     }
}
