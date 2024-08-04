<?php

namespace Tests\Feature\AdminPage\User;

use App\Models\User;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    protected function getRoute($value): string
    {
        return route('user.edit', $value);
    }

    protected function postRoute($value): string
    {
        return $this->secureRoute('user.update', $value);
    }

    /**
     * @test
     * @group f-user
     */
    public function usersCanAccessTheirOwnProfilePage()
    {
        $user = $this->normalUser();
        $response = $this->actingAs($user)
            ->get($this->getRoute($user->name));

        $response->assertOk();
    }

    /**
     * @test
     * @group f-user
     */
    public function adminCanAccessOtherUsersProfilePages()
    {
        $response = $this->actingAs($this->adminUser())
            ->get($this->getRoute($this->normalUser()->name));

        $response->assertOk();
    }

    /**
     * @test
     * @group f-user
     */
    public function adminUserCantAccessOtherUsersProfilePages()
    {
        $response = $this->actingAs($this->normalUser())
            ->get($this->getRoute($this->adminUser()->name));

        $response->assertForbidden();
    }

    /**
     * @test
     * @group f-user
     */
    public function adminCanChangeOtherUsersEmail()
    {
        $user = User::factory()->create(['email' => 'user_email@example.com']);

        $response = $this->actingAs($this->adminUser())
            ->from($this->getRoute($user->name))
            ->post($this->postRoute($user->id), [
                'email' => 'new_user_email@example.com',
            ]);

        $response
            ->assertRedirect($this->getRoute($user->name))
            ->assertSessionHas('flash_success');

        /** @var \App\Models\User */
        $userFresh = $user->fresh();

        $this->assertSame('new_user_email@example.com', $userFresh->email);
    }

    /**
     * @test
     * @group f-user
     */
    public function normalUserCantChangeOtherUsersEmail()
    {
        $user = User::factory()->create(['email' => 'user2@example.com']);

        $response = $this->actingAs($this->normalUser())
            ->from($this->getRoute($user->name))
            ->post($this->postRoute($user->id), [
                'email' => 'new_email_user2@example.com',
            ]);

        $response->assertForbidden();
        $this->assertSame('user2@example.com', $user->email);
    }

    /**
     * @test
     * @group f-user
     */
    public function validationEmailRequired()
    {
        $user = $this->normalUser();

        $response = $this->actingAs($user)
            ->from($this->getRoute($user->name))
            ->post($this->postRoute($user->id), [
                'email' => '',
            ]);

        $response
            ->assertRedirect($this->getRoute($user->name))
            ->assertSessionHasErrors('email');
    }

    /**
     * @test
     * @group f-user
     */
    public function validationEmailInvalidFormat()
    {
        $user = $this->normalUser();

        $response = $this->actingAs($user)
            ->from($this->getRoute($user->name))
            ->post($this->postRoute($user->id), [
                'email' => 'invalid_format',
            ]);

        $response
            ->assertRedirect($this->getRoute($user->name))
            ->assertSessionHasErrors('email');
    }

    /**
     * @test
     * @group f-user
     */
    public function validationEmailMaxLength()
    {
        $user = $this->normalUser();

        $response = $this->actingAs($user)
            ->from($this->getRoute($user->name))
            ->post($this->postRoute($user->id), [
                // 255 + 9
                'email' => str_repeat('a', 255) . '@mail.com',
            ]);

        $response
            ->assertRedirect($this->getRoute($user->name))
            ->assertSessionHasErrors('email');
    }

    /**
     * @test
     * @group f-user
     */
    public function validationEmailUnique()
    {
        $user = $this->normalUser();

        $response = $this->actingAs($user)
            ->from($this->getRoute($user->name))
            ->post($this->postRoute($user->id), [
                'email' => $this->normalUser()->email,
            ]);

        $response
            ->assertRedirect($this->getRoute($user->name))
            ->assertSessionHasErrors('email');
    }
}
