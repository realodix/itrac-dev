<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            RolesAndPermissionsSeeder::class,
        ]);

        // Multiple with factory
        // \App\Models\User::factory(200)->create();
        \App\Models\Issue::factory(3)->create();
        \App\Models\Comment::factory(10)->create();
    }
}
