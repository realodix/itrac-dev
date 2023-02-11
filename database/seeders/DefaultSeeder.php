<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = $this->user('admin', true);
        $user = $this->user('user');

        $issueByAdmin = $this->issue($admin);
        $issueByUser =  $this->issue($user);

        Comment::factory()->create([
            'author_id' => $admin->id,
            'issue_id'  => $issueByAdmin->id,
        ]);

        Comment::factory()->create([
            'author_id' => $user->id,
            'issue_id'  => $issueByAdmin->id,
        ]);

        Comment::factory()->create([
            'author_id' => $admin->id,
            'issue_id'  => $issueByUser->id,
        ]);

        Comment::factory()->create([
            'author_id' => $user->id,
            'issue_id'  => $issueByUser->id,
        ]);
    }

    public function user(string $username, bool $isAdmin = false): User
    {
        $user = User::factory()->create([
            'name'       => $username,
            'email'      => $username.'@realodix.test',
            'password'   => Hash::make($username),
        ]);

        if ($isAdmin) {
            $user->assignRole('admin');
        }

        return $user;
    }

    public function issue(User $user): Issue
    {
        return Issue::factory()->create([
            'author_id'   => $user->id,
            'title'       => 'Issue by '.$user->name,
            'description' => fake()->paragraphs(nb: 3, asText: true),
        ]);}
}
