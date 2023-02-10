<?php

namespace Database\Seeders;

use App\Enums\TimelineType;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory()->create([
            'author_id' => 1,
            'issue_id'  => 1,
            'type'      => TimelineType::COMMENT,
        ]);

        Comment::factory()->create([
            'author_id' => 2,
            'issue_id'  => 1,
            'type'      => TimelineType::COMMENT,
        ]);

        Comment::factory()->create([
            'author_id' => 1,
            'issue_id'  => 2,
            'type'      => TimelineType::COMMENT,
        ]);

        Comment::factory()->create([
            'author_id' => 2,
            'issue_id'  => 2,
            'type'      => TimelineType::COMMENT,
        ]);
    }
}
