<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Issue;
use App\Models\Timeline;
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
            RolesAndPermissionsSeeder::class,
            DefaultSeeder::class,
        ]);

        // Multiple with factory
        Issue::factory(3)
            ->for(User::factory()->create(), 'author')
            ->has(Timeline::factory(5))
            ->create();
    }
}
