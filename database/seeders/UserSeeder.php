<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        User::factory()->create([
            'name'       => 'admin',
            'email'      => 'admin@urlhub.test',
            'password'   => Hash::make('admin'),
            'created_at' => $now,
            'updated_at' => $now,
        ])->assignRole('admin');

        User::factory()->create([
            'name'       => 'user',
            'email'      => 'user@urlhub.test',
            'password'   => Hash::make('user'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
