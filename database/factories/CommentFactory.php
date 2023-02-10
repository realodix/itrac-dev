<?php

namespace Database\Factories;

use App\Enums\TimelineType;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Comment>
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id'   => User::factory(),
            'issue_id'    => Issue::factory(),
            'type'        => TimelineType::COMMENT,
            'description' => fake()->paragraph(),
        ];
    }
}
