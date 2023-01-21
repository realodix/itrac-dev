<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            IssueSeeder::class,
            CommentSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);

        // Multiple with factory
        Issue::factory(3)
            ->for(User::factory()->create(), 'authors')
            ->has(Comment::factory(25))
            ->create();
    }
}
