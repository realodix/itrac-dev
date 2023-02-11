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
        $admin = $this->userAdmin();
        $user = $this->user();

        $issueByAdmin = Issue::factory()->create([
            'author_id'   => $admin->id,
            'title'       => 'Issue by admin',
            'description' => fake()->paragraphs(nb: 3, asText: true),
        ]);

        $issueByUser =  Issue::factory()->create([
            'author_id'   => $user->id,
            'title'       => 'Issue by user',
            'description' => fake()->paragraphs(nb: 3, asText: true),
        ]);

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

    /**
     * @return User
     */
    public function userAdmin()
    {
        return User::factory()->create([
            'name'       => 'admin',
            'email'      => 'admin@realodix.test',
            'password'   => Hash::make('admin'),
        ])->assignRole('admin');
    }

    /**
     * @return User
     */
    public function user()
    {
        return User::factory()->create([
            'name'       => 'user',
            'email'      => 'user@realodix.test',
            'password'   => Hash::make('user'),
        ]);
    }
}
