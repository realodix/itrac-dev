<?php

namespace Database\Seeders;

use App\Enums\TimelineType;
use App\Models\Timeline;
use Illuminate\Database\Seeder;

class TimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Timeline::factory()->create([
            'author_id' => 1,
            'issue_id'  => 1,
            'type'      => TimelineType::Comment,
        ]);

        Timeline::factory()->create([
            'author_id' => 2,
            'issue_id'  => 1,
            'type'      => TimelineType::Comment,
        ]);

        Timeline::factory()->create([
            'author_id' => 1,
            'issue_id'  => 2,
            'type'      => TimelineType::Comment,
        ]);

        Timeline::factory()->create([
            'author_id' => 2,
            'issue_id'  => 2,
            'type'      => TimelineType::Comment,
        ]);
    }
}
