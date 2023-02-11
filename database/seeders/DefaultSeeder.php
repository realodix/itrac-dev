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
        $now = now();

        $admin = User::factory()->create([
            'name'       => 'admin',
            'email'      => 'admin@realodix.test',
            'password'   => Hash::make('admin'),
            'created_at' => $now,
            'updated_at' => $now,
        ])->assignRole('admin');

        $user = User::factory()->create([
            'name'       => 'user',
            'email'      => 'user@realodix.test',
            'password'   => Hash::make('user'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $issueByAdmin = Issue::factory()->create([
            'author_id'   => $admin->id,
            'title'       => 'Issue by admin',
            'description' => fake()->paragraphs(nb: 3, asText: true),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $issueByUser =  Issue::factory()->create([
            'author_id'   => $user->id,
            'title'       => 'Issue by user',
            'description' => fake()->paragraphs(nb: 3, asText: true),
            'created_at' => $now,
            'updated_at' => $now,
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
}
