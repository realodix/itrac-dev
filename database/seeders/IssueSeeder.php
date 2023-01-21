<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        DB::table('issues')->insert([
            'author_id'   => 1,
            'title'       => fake()->words(3, true),
            'description' => fake()->paragraphs(nb: 3, asText: true),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('issues')->insert([
            'author_id'   => 2,
            'title'       => fake()->words(3, true),
            'description' => fake()->paragraphs(nb: 3, asText: true),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
